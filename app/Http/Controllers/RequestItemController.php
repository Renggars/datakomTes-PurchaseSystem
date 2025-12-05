<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRequestItemForm;
use App\Models\Request as PurchaseRequest;
use App\Models\RequestItem;
use Illuminate\Support\Facades\Auth;

class RequestItemController extends Controller
{
    public function store(StoreRequestItemForm $request, $id)
    {
        // Cek apakah request milik user login
        $req = PurchaseRequest::where('requester_id', Auth::id())->findOrFail($id);

        $item = RequestItem::create([
            'request_id' => $req->id,
            ...$request->validated()
        ]);

        return response()->json($item, 201);
    }

    public function destroy($id)
    {
        $item = RequestItem::findOrFail($id);

        if ($item->request->requester_id !== Auth::id()) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $item->delete();

        return response()->json(['message' => 'Item deleted successfully']);
    }
}
