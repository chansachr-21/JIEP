<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Facility;
use App\Models\Complaint;
use App\Models\JobVacancy;
use App\Models\Announcement;
use App\Models\ActivityLog;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function stats(): JsonResponse
    {
        $totalCompanies = Company::where('is_active', true)->count();
        $verifiedCompanies = Company::where('is_active', true)->where('verification_status', 'verified')->count();
        $totalFacilities = Facility::where('is_active', true)->count();
        $totalComplaints = Complaint::count();
        $openComplaints = Complaint::whereNotIn('status', ['selesai', 'ditolak'])->count();
        $totalJobs = JobVacancy::where('is_published', true)->count();
        $activeJobs = JobVacancy::where('is_published', true)->where(function($q) {
            $q->whereNull('deadline')->orWhere('deadline', '>=', today());
        })->count();
        $totalAnnouncements = Announcement::where('is_published', true)->count();

        // Pengaduan per status
        $complaintsByStatus = Complaint::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status');

        // Perusahaan per kategori
        $companiesByCategory = Company::where('is_active', true)
            ->whereNotNull('category')
            ->selectRaw('category, COUNT(*) as count')
            ->groupBy('category')
            ->orderBy('count', 'desc')
            ->limit(8)
            ->get();

        // Verifikasi data
        $verificationStats = [
            'companies' => [
                'verified' => Company::where('verification_status', 'verified')->count(),
                'needs_verification' => Company::where('verification_status', 'needs_verification')->count(),
                'unverified' => Company::where('verification_status', 'unverified')->count(),
            ],
            'facilities' => [
                'verified' => Facility::where('verification_status', 'verified')->count(),
                'needs_verification' => Facility::where('verification_status', 'needs_verification')->count(),
                'unverified' => Facility::where('verification_status', 'unverified')->count(),
            ],
        ];

        // Pengaduan 7 hari terakhir
        $recentComplaintsChart = collect(range(6, 0))->map(function ($daysAgo) {
            $date = now()->subDays($daysAgo);
            return [
                'date' => $date->format('d M'),
                'count' => Complaint::whereDate('created_at', $date)->count(),
            ];
        });

        return response()->json([
            'data' => [
                'summary' => [
                    'total_companies' => $totalCompanies,
                    'verified_companies' => $verifiedCompanies,
                    'total_facilities' => $totalFacilities,
                    'total_complaints' => $totalComplaints,
                    'open_complaints' => $openComplaints,
                    'total_jobs' => $totalJobs,
                    'active_jobs' => $activeJobs,
                    'total_announcements' => $totalAnnouncements,
                ],
                'complaints_by_status' => $complaintsByStatus,
                'companies_by_category' => $companiesByCategory,
                'verification_stats' => $verificationStats,
                'recent_complaints_chart' => $recentComplaintsChart,
            ],
        ]);
    }

    public function recentActivity(): JsonResponse
    {
        $logs = ActivityLog::orderBy('created_at', 'desc')->limit(20)->get();
        return response()->json(['data' => $logs]);
    }
}
