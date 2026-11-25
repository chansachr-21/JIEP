<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\IndustrialEstateController;
use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\FacilityController;
use App\Http\Controllers\Api\MapController;
use App\Http\Controllers\Api\ComplaintController;
use App\Http\Controllers\Api\JobVacancyController;
use App\Http\Controllers\Api\AnnouncementController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\ActivityLogController;

/*
|--------------------------------------------------------------------------
| API Routes — INDUSTRIA
|--------------------------------------------------------------------------
*/

Route::prefix('v1')->group(function () {

    // Kawasan Industri
    Route::get('/industrial-estate', [IndustrialEstateController::class, 'show']);
    Route::get('/industrial-estate/stats', [IndustrialEstateController::class, 'stats']);

    // Peta
    Route::get('/map/locations', [MapController::class, 'locations']);
    Route::get('/map/filters', [MapController::class, 'filters']);

    // Perusahaan — publik (read)
    Route::get('/companies', [CompanyController::class, 'index']);
    Route::get('/companies/categories', [CompanyController::class, 'categories']);
    Route::get('/companies/{company}', [CompanyController::class, 'show']);

    // Fasilitas — publik (read)
    Route::get('/facilities', [FacilityController::class, 'index']);
    Route::get('/facilities/categories', [FacilityController::class, 'categories']);
    Route::get('/facilities/{facility}', [FacilityController::class, 'show']);

    // Pengaduan — publik (submit & track)
    Route::post('/complaints', [ComplaintController::class, 'store']);
    Route::get('/complaints/track/{number}', [ComplaintController::class, 'track']);

    // Lowongan — publik (read)
    Route::get('/jobs', [JobVacancyController::class, 'index']);
    Route::get('/jobs/{jobVacancy}', [JobVacancyController::class, 'show']);

    // Pengumuman — publik (read)
    Route::get('/announcements', [AnnouncementController::class, 'index']);
    Route::get('/announcements/{announcement}', [AnnouncementController::class, 'show']);

    // ========================
    // Admin routes (no auth — demo only)
    // ========================
    Route::prefix('admin')->group(function () {

        // Dashboard
        Route::get('/dashboard/stats', [DashboardController::class, 'stats']);
        Route::get('/dashboard/recent-activity', [DashboardController::class, 'recentActivity']);

        // Activity Logs
        Route::get('/activity-logs', [ActivityLogController::class, 'index']);

        // Perusahaan CRUD
        Route::post('/companies', [CompanyController::class, 'store']);
        Route::put('/companies/{company}', [CompanyController::class, 'update']);
        Route::delete('/companies/{company}', [CompanyController::class, 'destroy']);
        Route::post('/companies/import', [CompanyController::class, 'importCsv']);

        // Fasilitas CRUD
        Route::post('/facilities', [FacilityController::class, 'store']);
        Route::put('/facilities/{facility}', [FacilityController::class, 'update']);
        Route::delete('/facilities/{facility}', [FacilityController::class, 'destroy']);

        // Pengaduan admin
        Route::get('/complaints', [ComplaintController::class, 'index']);
        Route::get('/complaints/{complaint}', [ComplaintController::class, 'show']);
        Route::patch('/complaints/{complaint}/status', [ComplaintController::class, 'updateStatus']);
        Route::delete('/complaints/{complaint}', [ComplaintController::class, 'destroy']);

        // Lowongan CRUD
        Route::post('/jobs', [JobVacancyController::class, 'store']);
        Route::put('/jobs/{jobVacancy}', [JobVacancyController::class, 'update']);
        Route::delete('/jobs/{jobVacancy}', [JobVacancyController::class, 'destroy']);

        // Pengumuman CRUD
        Route::post('/announcements', [AnnouncementController::class, 'store']);
        Route::put('/announcements/{announcement}', [AnnouncementController::class, 'update']);
        Route::delete('/announcements/{announcement}', [AnnouncementController::class, 'destroy']);
    });
});

// Health check
Route::get('/health', fn() => response()->json([
    'status' => 'ok',
    'app' => 'INDUSTRIA API',
    'version' => '1.0.0',
    'timestamp' => now()->toIso8601String(),
]));
