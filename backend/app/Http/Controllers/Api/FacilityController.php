<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Facility;
use App\Services\ActivityLogService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class FacilityController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Facility::with('industrialEstate')
            ->when($request->search, fn($q) => $q->where('name', 'like', '%' . $request->search . '%'))
            ->when($request->category, fn($q) => $q->where('category', $request->category))
            ->when($request->verification_status, fn($q) => $q->where('verification_status', $request->verification_status))
            ->where('is_active', true)
            ->orderBy('category')
            ->orderBy('name');

        $perPage = min($request->input('per_page', 20), 100);
        return response()->json($query->paginate($perPage));
    }

    public function show(Facility $facility): JsonResponse
    {
        return response()->json(['data' => $facility->load('industrialEstate')]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'industrial_estate_id' => 'required|exists:industrial_estates,id',
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'description' => 'nullable|string|max:5000',
            'address' => 'nullable|string|max:500',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'operational_status' => 'nullable|string|max:100',
            'phone' => 'nullable|string|max:50',
            'verification_status' => 'nullable|in:verified,needs_verification,unverified',
            'data_source' => 'nullable|string|max:255',
            'source_url' => 'nullable|url|max:255',
            'last_verified_at' => 'nullable|date',
            'is_active' => 'nullable|boolean',
        ]);

        $facility = Facility::create($validated);
        ActivityLogService::log('create', 'facilities', $facility->id, null, $facility->toArray(), "Fasilitas baru ditambahkan: {$facility->name}");

        return response()->json(['data' => $facility, 'message' => 'Fasilitas berhasil ditambahkan.'], 201);
    }

    public function update(Request $request, Facility $facility): JsonResponse
    {
        $oldValues = $facility->toArray();
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'category' => 'sometimes|string|max:100',
            'description' => 'nullable|string|max:5000',
            'address' => 'nullable|string|max:500',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'operational_status' => 'nullable|string|max:100',
            'phone' => 'nullable|string|max:50',
            'verification_status' => 'nullable|in:verified,needs_verification,unverified',
            'data_source' => 'nullable|string|max:255',
            'source_url' => 'nullable|url|max:255',
            'last_verified_at' => 'nullable|date',
            'is_active' => 'nullable|boolean',
        ]);

        $facility->update($validated);
        ActivityLogService::log('update', 'facilities', $facility->id, $oldValues, $facility->fresh()->toArray(), "Fasilitas diperbarui: {$facility->name}");

        return response()->json(['data' => $facility, 'message' => 'Data fasilitas berhasil diperbarui.']);
    }

    public function destroy(Facility $facility): JsonResponse
    {
        $name = $facility->name;
        $id = $facility->id;
        ActivityLogService::log('delete', 'facilities', $id, $facility->toArray(), null, "Fasilitas dihapus: {$name}");
        $facility->delete();
        return response()->json(['message' => "Fasilitas '{$name}' berhasil dihapus."]);
    }

    public function categories(): JsonResponse
    {
        $categories = Facility::where('is_active', true)
            ->distinct()->pluck('category')->sort()->values();
        return response()->json(['data' => $categories]);
    }
}
