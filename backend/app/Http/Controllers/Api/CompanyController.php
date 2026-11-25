<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Services\ActivityLogService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class CompanyController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Company::with('industrialEstate')
            ->when($request->search, fn($q) => $q->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('description', 'like', '%' . $request->search . '%'))
            ->when($request->category, fn($q) => $q->where('category', $request->category))
            ->when($request->verification_status, fn($q) => $q->where('verification_status', $request->verification_status))
            ->when($request->is_featured, fn($q) => $q->where('is_featured', true))
            ->where('is_active', true)
            ->orderBy('is_featured', 'desc')
            ->orderBy('name');

        $perPage = min($request->input('per_page', 15), 100);
        $companies = $query->paginate($perPage);

        return response()->json($companies);
    }

    public function show(Company $company): JsonResponse
    {
        $company->load(['industrialEstate', 'jobVacancies' => fn($q) => $q->where('is_published', true)->orderBy('created_at', 'desc')->limit(5)]);
        return response()->json(['data' => $company]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'industrial_estate_id' => 'required|exists:industrial_estates,id',
            'name' => 'required|string|max:255',
            'category' => 'nullable|string|max:100',
            'description' => 'nullable|string|max:5000',
            'address' => 'nullable|string|max:500',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|url|max:255',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'verification_status' => 'nullable|in:verified,needs_verification,unverified',
            'data_source' => 'nullable|string|max:255',
            'source_url' => 'nullable|url|max:255',
            'last_verified_at' => 'nullable|date',
            'is_featured' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['slug'] = Str::slug($validated['name']) . '-' . Str::random(6);

        $company = Company::create($validated);

        ActivityLogService::log('create', 'companies', $company->id, null, $company->toArray(), "Perusahaan baru ditambahkan: {$company->name}");

        return response()->json(['data' => $company, 'message' => 'Perusahaan berhasil ditambahkan.'], 201);
    }

    public function update(Request $request, Company $company): JsonResponse
    {
        $oldValues = $company->toArray();

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'category' => 'nullable|string|max:100',
            'description' => 'nullable|string|max:5000',
            'address' => 'nullable|string|max:500',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|url|max:255',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'verification_status' => 'nullable|in:verified,needs_verification,unverified',
            'data_source' => 'nullable|string|max:255',
            'source_url' => 'nullable|url|max:255',
            'last_verified_at' => 'nullable|date',
            'is_featured' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
        ]);

        $company->update($validated);

        ActivityLogService::log('update', 'companies', $company->id, $oldValues, $company->fresh()->toArray(), "Data perusahaan diperbarui: {$company->name}");

        return response()->json(['data' => $company, 'message' => 'Data perusahaan berhasil diperbarui.']);
    }

    public function destroy(Company $company): JsonResponse
    {
        $name = $company->name;
        $id = $company->id;

        ActivityLogService::log('delete', 'companies', $id, $company->toArray(), null, "Perusahaan dihapus: {$name}");
        $company->delete();

        return response()->json(['message' => "Perusahaan '{$name}' berhasil dihapus."]);
    }

    public function importCsv(Request $request): JsonResponse
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt|max:2048',
            'industrial_estate_id' => 'required|exists:industrial_estates,id',
        ]);

        $file = $request->file('file');
        $handle = fopen($file->path(), 'r');
        $headers = fgetcsv($handle);
        $imported = 0;
        $errors = [];

        $expectedHeaders = ['name', 'category', 'description', 'address', 'phone', 'email', 'website', 'data_source', 'source_url'];

        while (($row = fgetcsv($handle)) !== false) {
            if (count($row) < 1) continue;

            $data = array_combine(array_slice($expectedHeaders, 0, count($row)), $row);
            if (empty($data['name'])) continue;

            try {
                Company::create([
                    'industrial_estate_id' => $request->industrial_estate_id,
                    'name' => strip_tags($data['name']),
                    'slug' => Str::slug($data['name']) . '-' . Str::random(6),
                    'category' => $data['category'] ?? null,
                    'description' => isset($data['description']) ? strip_tags($data['description']) : null,
                    'address' => $data['address'] ?? null,
                    'phone' => $data['phone'] ?? null,
                    'email' => $data['email'] ?? null,
                    'website' => $data['website'] ?? null,
                    'data_source' => $data['data_source'] ?? 'Import CSV',
                    'source_url' => $data['source_url'] ?? null,
                    'verification_status' => 'needs_verification',
                ]);
                $imported++;
            } catch (\Exception $e) {
                $errors[] = $data['name'] . ': ' . $e->getMessage();
            }
        }

        fclose($handle);

        ActivityLogService::log('import', 'companies', null, null, ['count' => $imported], "Import CSV: {$imported} perusahaan ditambahkan.");

        return response()->json([
            'message' => "{$imported} perusahaan berhasil diimpor.",
            'imported' => $imported,
            'errors' => $errors,
        ]);
    }

    public function categories(): JsonResponse
    {
        $categories = Company::where('is_active', true)
            ->whereNotNull('category')
            ->distinct()
            ->pluck('category')
            ->sort()
            ->values();

        return response()->json(['data' => $categories]);
    }
}
