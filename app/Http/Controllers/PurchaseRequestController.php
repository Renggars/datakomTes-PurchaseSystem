<?php

namespace App\Http\Controllers;

use App\Http\Requests\IndexPurchaseRequest;
use App\Http\Requests\ShowPurchaseRequest;
use App\Models\Request as PurchaseRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PurchaseRequestController extends Controller
{
    public function index(IndexPurchaseRequest $request)
    {
        $user = auth()->user();
        $query = PurchaseRequest::with(['requester', 'category']);

        if (!in_array($user->role, ['pemohon'])) {
            $query = $query->with(['approvals']);
        } else {
            $query->where('requester_id', $user->id);
        }

        // Optional filter dari query params
        if ($request->status) $query->where('status', $request->status);
        if ($request->category_id) $query->where('category_id', $request->category_id);
        if ($request->division_id) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('division_id', $request->division_id);
            });
        }
        if ($request->start_date) $query->whereDate('created_at', '>=', $request->start_date);
        if ($request->end_date) $query->whereDate('created_at', '<=', $request->end_date);

        $requests = $query->orderByDesc('created_at')->get();

        return response()->json([
            'status' => 'success',
            'data' => $requests
        ]);
    }

    public function show(ShowPurchaseRequest $request, $id)
    {
        $purchaseRequest = PurchaseRequest::with(['requester', 'category', 'approvals'])->findOrFail($id);
        $user = auth()->user();

        if ($user->role === 'pemohon' && $purchaseRequest->requester_id !== $user->id) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized access'
            ], 403);
        }

        return response()->json([
            'status' => 'success',
            'data' => $purchaseRequest
        ]);
    }
}
