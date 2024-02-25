<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        /* Lots expiring in next 10 days */
        $lotsExpiring = $user->lots()
            ->expiringInNextDays()
            ->with('product')
            ->get();

        /* Products with less than 10 stock */
        $productsLessStock = $user->products()
            ->lessStock()
            ->get();

        return view('pages.dashboard', compact('lotsExpiring', 'productsLessStock'));
    }
}
