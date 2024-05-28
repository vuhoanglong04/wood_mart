<?php

namespace App\Http\Controllers;

use App\Models\Vouchers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class VouchersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!Gate::allows('vouchers.view')) {
            abort(404);
        }
        $vouchers = Vouchers::orderBy('created_at' , 'desc')->get();
        return view('vouchers.list', compact('vouchers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!Gate::allows('vouchers.add')) {
            abort(404);
        }
        $request->validate(
            [
                'code' => "required | min:10",
                'discount'=>'required',
                'date_expiry'=>'required'
            ],
            [
                'code.required' => "Code must be required",
                'code.min' => "Code must be at least 10 characters",
                'discount.required' => "Code must be required",
                'data_expiry.required' => "Code must be required",
            ]
        );

        $voucher = new Vouchers();
        $voucher->code = $request->code;
        $voucher->discount = $request->discount;
        $voucher->date_expiry = $request->date_expiry;
        $voucher->save();
        return back()->with('success', 'Add new voucher successfully!');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if (!Gate::allows('vouchers.update')) {
            abort(404);
        }
        $voucher = Vouchers::find($id);
        return view('vouchers.edit' , compact('voucher'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (!Gate::allows('vouchers.update')) {
            abort(404);
        }
        $request->validate(
            [
                'code' => "required | min:10",
                'discount'=>'required',
            ],
            [
                'code.required' => "Code must be required",
                'code.min' => "Code must be at least 10 characters",
                'discount.required' => "Code must be required",
            ]
        );
        $voucher = Vouchers::find($id);
        $voucher->code = $request->code;
        $voucher->discount = $request->discount;
        if($request->date_expiry){
            $voucher->date_expiry = $request->date_expiry;
        }
        $voucher->save();
        return redirect()->route('admin.vouchers.index')->with('success', 'Update voucher successfully!');


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (!Gate::allows('vouchers.forceDelete')) {
            abort(404);
        }
        $voucher = Vouchers::find($id)->delete();
        return true;
    }
}
