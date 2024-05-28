<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromCollection;

class UsersExport implements FromView
{
    public function view(): View
    {
        return view('users.export', [
            'users' => User::select('email' , 'phone_number' , 'full_name' , 'created_at')->get()
        ]);
    }
}
