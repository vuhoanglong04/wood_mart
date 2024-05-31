<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Orders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {

    
        //Now
        $currentDate = Carbon::now()->day;
        $totalToday = Orders::where('status', '>=', 2)->whereDay('created_at', $currentDate)->sum('total');
        //Current month
        $currentMonth = Carbon::now()->month;
        $totalMonth = Orders::where('status', '>=', 2)->whereMonth('created_at', $currentMonth)->sum('total');
        //Current year
        $currentYear = Carbon::now()->year;
        $totalYear = Orders::where('status', '>=', 2)->whereYear('created_at', $currentYear)->sum('total');
        //Earning all
        $grandTotalEarning = Orders::where('status', '>=', 2)->sum('total');

        //Count User
        $allUser = User::withTrashed()->get()->count();
        //Online User
        $onlineUser = User::withTrashed()->where('is_online', 1)->get()->count();
        //Sum Monthly
        $monthlyTotals = [];
        for ($month = 1; $month <= 12; $month++) {
            $total = Orders::where('status', '>=', 2)
                ->whereYear('created_at', $currentYear)
                ->whereMonth('created_at', $month)
                ->sum('total');

            $monthlyTotals[$month] = $total;
        }
        return view('dashboard', compact('totalToday', 'totalMonth', 'totalYear', 'allUser', 'onlineUser', 'grandTotalEarning' , 'monthlyTotals'));
    }
}
