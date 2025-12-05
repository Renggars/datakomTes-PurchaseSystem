<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApprovalActionForm;
use App\Models\Approval;
use App\Models\Request as PurchaseRequest;
use Illuminate\Support\Facades\Auth;

class ApprovalController extends Controller
{
    public function listPending()
    {
        $pending = PurchaseRequest::whereIn('status', ['diajukan', 'menunggu_approval'])->get();

        return response()->json([
            'status' => 'success',
            'data' => $pending
        ]);
    }

    public function approve(ApprovalActionForm $request, $id)
    {
        $purchaseRequest = PurchaseRequest::findOrFail($id);

        // Jika status sudah diproses
        if (!in_array($purchaseRequest->status, ['diajukan', 'menunggu_approval'])) {
            return response()->json([
                'status' => 'error',
                'message' => 'Request already processed'
            ], 409);
        }

        // Simpan riwayat approval
        Approval::create([
            'request_id'  => $purchaseRequest->id,
            'approver_id' => Auth::id(),
            'status'      => $request->status,
            'approved_at' => now(),
        ]);

        // Update status di tabel requests
        $purchaseRequest->update([
            'status' => $request->status
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Request ' . strtolower($request->status) . ' successfully',
            'data' => $purchaseRequest
        ]);
    }
}
