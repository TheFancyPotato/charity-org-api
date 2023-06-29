<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Family;
use App\Models\Invoice;

class HomeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        $year = request('year', now()->format('Y'));
        $month = request('month', now()->format('m'));

        return response()->json([
            'activeFamiliesCount' => Family::count(),
            'deletedFamiliesCount' => Family::onlyTrashed()->count(),
            'totalMoneySpent' => Invoice::whereYear('date', $year)->whereMonth('date', $month)->sum('amount'),
            'pendingFamilies' => Family::whereDoesntHave('invoices', function ($query) use ($year, $month) {
                $query->whereYear('date', $year)->whereMonth('date', $month);
            })->count(),
        ]);
    }
}
