<?php

namespace App\Http\Controllers;

use App\Models\Request as PurchaseRequest;
use App\Models\Category;
use App\Models\User;
use App\Models\Division;

class ReportController extends Controller
{
    // Endpoint: GET /reports/summary
    public function summary()
    {
        // Summary jumlah request per status
        $statusSummary = PurchaseRequest::selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->get();

        // Summary jumlah request per division
        $divisionSummary = Division::withCount(['users as total_requests' => function ($query) {
            $query->join('requests', 'users.id', '=', 'requests.requester_id');
        }])->get(['name']);

        return response()->json([
            'status_summary' => $statusSummary,
            'division_summary' => $divisionSummary
        ]);
    }

    // Endpoint: GET /reports/top-categories
    public function topCategories()
    {
        $topCategories = Category::withCount('requests')
            ->orderByDesc('requests_count')
            ->limit(10)
            ->get(['id', 'name']);

        return response()->json([
            'top_categories' => $topCategories
        ]);
    }
}
