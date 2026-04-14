<?php

namespace App\Http\Controllers;

use App\Models\Items;
use App\Models\Lendings;
use App\Models\Categories;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function AdminDashboard()
    {
        $totalItems      = Items::sum('total_stock');
        $totalCategories = Categories::count();
        $totalUsers      = User::count();
        $totalLendings   = Lendings::whereNull('return_date')->count();
        $recentLendings  = Lendings::with('user')
                            ->latest()
                            ->take(5)
                            ->get();

        return view('admin.dashboard', compact(
            'totalItems',
            'totalCategories',
            'totalUsers',
            'totalLendings',
            'recentLendings'
        ));
    }

    /**
     * Dashboard Staff – tampilkan peminjaman milik staff ini
     */
    public function StaffDashboard()
    {
        $myLendings = Lendings::where('user_id', Auth::id())
                        ->latest()
                        ->get();

        $myActive   = $myLendings->whereNull('return_date')->count();
        $myReturned = $myLendings->whereNotNull('return_date')->count();
        $totalItems = Items::sum('total_stock');

        return view('staff.dashboard', compact(
            'myLendings',
            'myActive',
            'myReturned',
            'totalItems'
        ));
    }
}
