<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\JobVacancy;
use App\Services\ActivityLogService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class JobVacancyController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = JobVacancy::with('company')
            ->when($request->search, fn($q) => $q->where('title', 'like', '%' . $request->search . '%')
                ->orWhere('company_name', 'like', '%' . $request->search . '%'))
            ->when($request->category, fn($q) => $q->where('category', $request->category))
            ->when($request->employment_type, fn($q) => $q->where('employment_type', $request->employment_type))
            ->when(!$request->include_expired, fn($q) => $q->where(function($sub) {
                $sub->whereNull('deadline')->orWhere('deadline', '>=', today());
            }))
            ->where('is_published', true)
            ->orderBy('published_at', 'desc')
            ->orderBy('created_at', 'desc');

        $perPage = min($request->input('per_page', 12), 100);
        return response()->json($query->paginate($perPage));
    }

    public function show(JobVacancy $jobVacancy): JsonResponse
    {
        return response()->json(['data' => $jobVacancy->load('company')]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'company_id' => 'nullable|exists:companies,id',
            'company_name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'category' => 'nullable|string|max:100',
            'description' => 'nullable|string|max:10000',
            'requirements' => 'nullable|string|max:10000',
            'employment_type' => 'nullable|in:full-time,part-time,kontrak,magang',
            'location' => 'nullable|string|max:255',
            'is_published' => 'nullable|boolean',
            'is_demo' => 'nullable|boolean',
            'published_at' => 'nullable|date',
            'deadline' => 'nullable|date|after:today',
            'source_url' => 'nullable|url|max:255',
            'data_source' => 'nullable|string|max:255',
            'verification_status' => 'nullable|in:verified,needs_verification,unverified',
            'last_verified_at' => 'nullable|date',
        ]);

        $job = JobVacancy::create($validated);
        ActivityLogService::log('create', 'job_vacancies', $job->id, null, $job->toArray(), "Lowongan baru: {$job->title} di {$job->company_name}");

        return response()->json(['data' => $job, 'message' => 'Lowongan berhasil ditambahkan.'], 201);
    }

    public function update(Request $request, JobVacancy $jobVacancy): JsonResponse
    {
        $oldValues = $jobVacancy->toArray();
        $validated = $request->validate([
            'company_id' => 'nullable|exists:companies,id',
            'company_name' => 'sometimes|string|max:255',
            'title' => 'sometimes|string|max:255',
            'category' => 'nullable|string|max:100',
            'description' => 'nullable|string|max:10000',
            'requirements' => 'nullable|string|max:10000',
            'employment_type' => 'nullable|in:full-time,part-time,kontrak,magang',
            'location' => 'nullable|string|max:255',
            'is_published' => 'nullable|boolean',
            'published_at' => 'nullable|date',
            'deadline' => 'nullable|date',
            'source_url' => 'nullable|url|max:255',
            'data_source' => 'nullable|string|max:255',
            'verification_status' => 'nullable|in:verified,needs_verification,unverified',
        ]);

        $jobVacancy->update($validated);
        ActivityLogService::log('update', 'job_vacancies', $jobVacancy->id, $oldValues, $jobVacancy->fresh()->toArray(), "Lowongan diperbarui: {$jobVacancy->title}");

        return response()->json(['data' => $jobVacancy, 'message' => 'Lowongan berhasil diperbarui.']);
    }

    public function destroy(JobVacancy $jobVacancy): JsonResponse
    {
        $title = $jobVacancy->title;
        $id = $jobVacancy->id;
        ActivityLogService::log('delete', 'job_vacancies', $id, $jobVacancy->toArray(), null, "Lowongan dihapus: {$title}");
        $jobVacancy->delete();
        return response()->json(['message' => "Lowongan '{$title}' berhasil dihapus."]);
    }
}
