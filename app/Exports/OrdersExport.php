<?php

namespace App\Exports;

use App\Models\Orders;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromCollection;

class OrdersExport implements FromView
{
    public function view(): View
    {
        return view('orders.export', [
            'orders' => Orders::all()
        ]);
    }
}
