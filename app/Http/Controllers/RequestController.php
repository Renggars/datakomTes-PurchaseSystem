<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRequestForm;
use App\Http\Requests\UpdateRequestForm;
use App\Models\Request;
use Illuminate\Support\Facades\Auth;

class RequestController extends Controller
{
    public function store(StoreRequestForm $request)
    {
        $newRequest = Request::create([
            'requester_id' => Auth::id(),
            ...$request->validated(),
        ]);

        return response()->json($newRequest, 201);
    }

    public function update(UpdateRequestForm $request, $id)
    {
        $req = Request::where('requester_id', Auth::id())->findOrFail($id);
        $req->update($request->validated());
        return response()->json($req);
    }

    public function destroy($id)
    {
        $req = Request::where('requester_id', Auth::id())->findOrFail($id);
        $req->delete();
        return response()->json(['message' => 'Request deleted successfully']);
    }
}
