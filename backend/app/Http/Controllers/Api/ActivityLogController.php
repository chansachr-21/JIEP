<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ActivityLogController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = ActivityLog::when($request->action, fn($q) => $q->where('action', $request->action))
            ->when($request->table_name, fn($q) => $q->where('table_name', $request->table_name))
            ->orderBy('created_at', 'desc');

        $perPage = min($request->input('per_page', 20), 100);
        return response()->json($query->paginate($perPage));
    }
}
