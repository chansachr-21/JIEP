<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\IndustrialEstate;
use App\Models\Company;
use App\Models\Facility;
use App\Models\Complaint;
use App\Models\JobVacancy;
use App\Models\Announcement;
use App\Models\ActivityLog;
use Illuminate\Http\JsonResponse;

class IndustrialEstateController extends Controller
{
    public function show(): JsonResponse
    {
        $estate = IndustrialEstate::with(['accessPoints', 'facilities'])->first();

        if (!$estate) {
            return response()->json(['message' => 'Data kawasan industri belum tersedia.'], 404);
        }

        return response()->json([
            'data' => $estate,
            'meta' => [
                'disclaimer' => 'Data ini bersumber dari publikasi resmi JIEP dan dokumen publik. Beberapa informasi mungkin masih dalam proses verifikasi.',
            ],
        ]);
    }

    public function stats(): JsonResponse
    {
        $estate = IndustrialEstate::first();

        return response()->json([
            'data' => [
                'companies_count' => Company::where('is_active', true)->count(),
                'companies_verified_count' => Company::where('is_active', true)->where('verification_status', 'verified')->count(),
                'facilities_count' => Facility::where('is_active', true)->count(),
                'complaints_count' => Complaint::count(),
                'complaints_open_count' => Complaint::whereNotIn('status', ['selesai', 'ditolak'])->count(),
                'job_vacancies_count' => JobVacancy::where('is_published', true)->where(function ($q) {
                    $q->whereNull('deadline')->orWhere('deadline', '>=', today());
                })->count(),
                'announcements_count' => Announcement::where('is_published', true)->count(),
                'estate_area_hectares' => $estate?->area_hectares,
                'estate_established_year' => $estate?->established_year,
                'companies_approximate' => '>500',
                'companies_approximate_source' => 'PT JIEP & PT Danareksa Annual Report 2025',
            ],
        ]);
    }
}
