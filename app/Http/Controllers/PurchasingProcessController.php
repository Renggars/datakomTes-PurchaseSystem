<?php

namespace App\Http\Controllers;

use App\Http\Requests\PurchasingProcessForm;
use App\Models\Request as PurchaseRequest;
use Illuminate\Http\Request;

class PurchasingProcessController extends Controller
{
    // Detail proses purchasing suatu request
    public function show($id)
    {
        $purchaseRequest = PurchaseRequest::with('items', 'requester', 'category')
            ->findOrFail($id);

        return response()->json([
            'status' => 'success',
            'data' => $purchaseRequest
        ]);
    }

    public function update(PurchasingProcessForm $request, $id)
    {
        $purchaseRequest = PurchaseRequest::findOrFail($id);

        if ($purchaseRequest->status !== 'approved') {
            return response()->json([
                'status' => 'error',
                'message' => 'Request must be approved before purchasing process'
            ], 409);
        }

        $purchaseRequest->update([
            'status' => $request->status,
            'note_purchasing' => $request->note ?? null,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Purchasing process updated successfully',
            'data' => $purchaseRequest
        ]);
    }
}
