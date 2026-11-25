<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\ComplaintStatusHistory;
use App\Services\ActivityLogService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ComplaintController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Complaint::with('statusHistories')
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->when($request->search, fn($q) => $q->where('complaint_number', 'like', '%' . $request->search . '%')
                ->orWhere('title', 'like', '%' . $request->search . '%'))
            ->orderBy('created_at', 'desc');

        $perPage = min($request->input('per_page', 15), 100);
        return response()->json($query->paginate($perPage));
    }

    public function show(Complaint $complaint): JsonResponse
    {
        return response()->json(['data' => $complaint->load('statusHistories')]);
    }

    public function track(string $number): JsonResponse
    {
        $complaint = Complaint::where('complaint_number', $number)
            ->with('statusHistories')
            ->first();

        if (!$complaint) {
            return response()->json(['message' => 'Nomor pengaduan tidak ditemukan.'], 404);
        }

        return response()->json([
            'data' => $complaint,
            'disclaimer' => 'Pengaduan ini hanya tersimpan dalam sistem demonstrasi INDUSTRIA dan tidak dikirim ke PT JIEP.',
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|in:infrastruktur,keamanan,kebersihan,administrasi,lainnya',
            'description' => 'required|string|min:20|max:3000',
            'location' => 'nullable|string|max:255',
            'reporter_name' => 'nullable|string|max:100',
        ]);

        $validated['is_demo'] = true;
        $validated['status'] = 'diterima';

        $complaint = Complaint::create($validated);

        // Catat status awal
        ComplaintStatusHistory::create([
            'complaint_id' => $complaint->id,
            'status' => 'diterima',
            'note' => 'Pengaduan diterima oleh sistem demonstrasi INDUSTRIA.',
        ]);

        return response()->json([
            'data' => $complaint->load('statusHistories'),
            'message' => 'Pengaduan berhasil dikirim.',
            'complaint_number' => $complaint->complaint_number,
            'disclaimer' => 'Pengaduan ini hanya tersimpan dalam sistem demonstrasi INDUSTRIA dan TIDAK dikirim ke PT JIEP atau pihak mana pun.',
        ], 201);
    }

    public function updateStatus(Request $request, Complaint $complaint): JsonResponse
    {
        $validated = $request->validate([
            'status' => 'required|in:diterima,ditinjau,diproses,selesai,ditolak',
            'note' => 'nullable|string|max:1000',
        ]);

        $oldStatus = $complaint->status;
        $complaint->update(['status' => $validated['status']]);

        ComplaintStatusHistory::create([
            'complaint_id' => $complaint->id,
            'status' => $validated['status'],
            'note' => $validated['note'] ?? null,
        ]);

        ActivityLogService::log(
            'status_change', 'complaints', $complaint->id,
            ['status' => $oldStatus],
            ['status' => $validated['status']],
            "Status pengaduan {$complaint->complaint_number} diubah dari '{$oldStatus}' ke '{$validated['status']}'"
        );

        return response()->json(['data' => $complaint->fresh()->load('statusHistories'), 'message' => 'Status pengaduan berhasil diperbarui.']);
    }

    public function destroy(Complaint $complaint): JsonResponse
    {
        $number = $complaint->complaint_number;
        ActivityLogService::log('delete', 'complaints', $complaint->id, $complaint->toArray(), null, "Pengaduan dihapus: {$number}");
        $complaint->delete();
        return response()->json(['message' => "Pengaduan '{$number}' berhasil dihapus."]);
    }
}
