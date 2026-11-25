<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Services\ActivityLogService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class AnnouncementController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Announcement::with('industrialEstate')
            ->when($request->search, fn($q) => $q->where('title', 'like', '%' . $request->search . '%'))
            ->when($request->category, fn($q) => $q->where('category', $request->category))
            ->when($request->is_official !== null, fn($q) => $q->where('is_official', filter_var($request->is_official, FILTER_VALIDATE_BOOLEAN)))
            ->where('is_published', true)
            ->orderBy('published_at', 'desc')
            ->orderBy('created_at', 'desc');

        $perPage = min($request->input('per_page', 10), 100);
        return response()->json($query->paginate($perPage));
    }

    public function show(Announcement $announcement): JsonResponse
    {
        return response()->json(['data' => $announcement->load('industrialEstate')]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'industrial_estate_id' => 'nullable|exists:industrial_estates,id',
            'title' => 'required|string|max:255',
            'category' => 'required|in:umum,operasional,keamanan,acara,demo',
            'content' => 'required|string|max:20000',
            'is_official' => 'nullable|boolean',
            'is_demo' => 'nullable|boolean',
            'is_published' => 'nullable|boolean',
            'published_at' => 'nullable|date',
            'source_url' => 'nullable|url|max:255',
            'data_source' => 'nullable|string|max:255',
            'verification_status' => 'nullable|in:verified,needs_verification,unverified',
        ]);

        if (empty($validated['published_at'])) {
            $validated['published_at'] = today();
        }

        $announcement = Announcement::create($validated);
        ActivityLogService::log('create', 'announcements', $announcement->id, null, $announcement->toArray(), "Pengumuman baru: {$announcement->title}");

        return response()->json(['data' => $announcement, 'message' => 'Pengumuman berhasil ditambahkan.'], 201);
    }

    public function update(Request $request, Announcement $announcement): JsonResponse
    {
        $oldValues = $announcement->toArray();
        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'category' => 'sometimes|in:umum,operasional,keamanan,acara,demo',
            'content' => 'sometimes|string|max:20000',
            'is_official' => 'nullable|boolean',
            'is_demo' => 'nullable|boolean',
            'is_published' => 'nullable|boolean',
            'published_at' => 'nullable|date',
            'source_url' => 'nullable|url|max:255',
            'data_source' => 'nullable|string|max:255',
            'verification_status' => 'nullable|in:verified,needs_verification,unverified',
        ]);

        $announcement->update($validated);
        ActivityLogService::log('update', 'announcements', $announcement->id, $oldValues, $announcement->fresh()->toArray(), "Pengumuman diperbarui: {$announcement->title}");

        return response()->json(['data' => $announcement, 'message' => 'Pengumuman berhasil diperbarui.']);
    }

    public function destroy(Announcement $announcement): JsonResponse
    {
        $title = $announcement->title;
        $id = $announcement->id;
        ActivityLogService::log('delete', 'announcements', $id, $announcement->toArray(), null, "Pengumuman dihapus: {$title}");
        $announcement->delete();
        return response()->json(['message' => "Pengumuman '{$title}' berhasil dihapus."]);
    }
}
