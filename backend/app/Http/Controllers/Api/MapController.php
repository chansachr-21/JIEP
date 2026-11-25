<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Facility;
use App\Models\AccessPoint;
use App\Models\IndustrialEstate;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MapController extends Controller
{
    public function locations(Request $request): JsonResponse
    {
        $locations = collect();

        // Kantor pengelola (koordinat terverifikasi saja)
        $estate = IndustrialEstate::whereNotNull('latitude')->whereNotNull('longitude')
            ->where('verification_status', 'verified')->get()->map(fn($e) => [
                'id' => 'estate-' . $e->id,
                'type' => 'estate',
                'label' => 'Kantor Pengelola',
                'name' => $e->name,
                'latitude' => (float) $e->latitude,
                'longitude' => (float) $e->longitude,
                'description' => $e->address,
                'verification_status' => $e->verification_status,
            ]);
        $locations = $locations->merge($estate);

        // Perusahaan (hanya yang terverifikasi dan ada koordinat)
        if (!$request->type || $request->type === 'company') {
            $companies = Company::whereNotNull('latitude')->whereNotNull('longitude')
                ->where('is_active', true)
                ->where('verification_status', 'verified')
                ->get()->map(fn($c) => [
                    'id' => 'company-' . $c->id,
                    'type' => 'company',
                    'label' => 'Perusahaan',
                    'name' => $c->name,
                    'latitude' => (float) $c->latitude,
                    'longitude' => (float) $c->longitude,
                    'description' => $c->address,
                    'category' => $c->category,
                    'verification_status' => $c->verification_status,
                    'link_id' => $c->id,
                ]);
            $locations = $locations->merge($companies);
        }

        // Fasilitas (hanya yang terverifikasi dan ada koordinat)
        if (!$request->type || $request->type === 'facility') {
            $facilities = Facility::whereNotNull('latitude')->whereNotNull('longitude')
                ->where('is_active', true)
                ->where('verification_status', 'verified')
                ->get()->map(fn($f) => [
                    'id' => 'facility-' . $f->id,
                    'type' => 'facility',
                    'label' => 'Fasilitas',
                    'name' => $f->name,
                    'latitude' => (float) $f->latitude,
                    'longitude' => (float) $f->longitude,
                    'description' => $f->description,
                    'category' => $f->category,
                    'verification_status' => $f->verification_status,
                ]);
            $locations = $locations->merge($facilities);
        }

        // Titik akses (hanya yang terverifikasi)
        if (!$request->type || $request->type === 'access') {
            $access = AccessPoint::whereNotNull('latitude')->whereNotNull('longitude')
                ->where('verification_status', 'verified')
                ->get()->map(fn($a) => [
                    'id' => 'access-' . $a->id,
                    'type' => 'access',
                    'label' => 'Akses Kawasan',
                    'name' => $a->name,
                    'latitude' => (float) $a->latitude,
                    'longitude' => (float) $a->longitude,
                    'description' => $a->road_name,
                    'verification_status' => $a->verification_status,
                ]);
            $locations = $locations->merge($access);
        }

        return response()->json([
            'data' => $locations->values(),
            'meta' => [
                'total' => $locations->count(),
                'note' => 'Hanya menampilkan lokasi dengan koordinat yang telah diverifikasi dari sumber resmi.',
                'center' => [
                    'latitude' => -6.1826,
                    'longitude' => 106.9007,
                    'note' => 'Pusat peta merupakan perkiraan umum kawasan Pulogadung untuk navigasi awal. Bukan koordinat resmi.',
                ],
            ],
        ]);
    }

    public function filters(): JsonResponse
    {
        return response()->json([
            'data' => [
                ['key' => 'all', 'label' => 'Semua Lokasi', 'color' => '#3b82f6'],
                ['key' => 'estate', 'label' => 'Kantor Pengelola', 'color' => '#8b5cf6'],
                ['key' => 'company', 'label' => 'Perusahaan', 'color' => '#06b6d4'],
                ['key' => 'facility', 'label' => 'Fasilitas', 'color' => '#10b981'],
                ['key' => 'access', 'label' => 'Akses Kawasan', 'color' => '#f59e0b'],
                ['key' => 'infrastructure', 'label' => 'Infrastruktur', 'color' => '#ef4444'],
            ],
        ]);
    }
}
