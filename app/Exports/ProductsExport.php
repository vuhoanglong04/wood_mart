<?php

namespace App\Exports;

use App\Models\User;
use App\Models\Orders;
use App\Models\Products;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromCollection;

class ProductsExport implements FromView
{
    public function view(): View
    {
        return view('products.export', [
            'products' => Products::all()
        ]);
    }
}
