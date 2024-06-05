<?php

namespace App\Http\Controllers\API;

use App\Models\UserAddress;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class UserAddressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $address = UserAddress::all();
        if($request->user_id)     $address = UserAddress::where('user_id', $request->user_id)->get();
        $arr = [
            'status' => 200,
            'data' => $address
        ];
        return response()->json($arr, 200);
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
        $validator = Validator::make($request->all() , [
            'country' => 'required',
            'city' => 'required',
            'detail_address' => 'required',
            'zip_code' => 'required',
        ], [
            'country.required' => 'Please select your country',
            'city.required' => 'Please enter your city',
            'detail_address.required' => 'Please enter your detail address',
            'zip_code.required' => 'Please enter your zip code'
        ]);
        if ($validator->fails()) {
            $arr = [
                'success' => false,
                'status' => 500,
                'message' => 'Validation failed',
                'data' => $validator->errors()
            ];
            return response()->json($arr, 500);
        }
        $newAddress = new UserAddress();
        $newAddress->user_id = $request->user_id;
        $newAddress->country = $request->country;
        $newAddress->city = $request->city;
        $newAddress->detail_address = $request->detail_address;
        $newAddress->zip_code = $request->zip_code;
        $newAddress->save();
        $arr = [
            'status' => 201,
            'message' => "Create new address sucessfully",
            'data' => $newAddress
        ];
        return response()->json($arr, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all() , [
            'country' => 'required',
            'city' => 'required',
            'detail_address' => 'required',
            'zip_code' => 'required',
        ], [
            'country.required' => 'Please select your country',
            'city.required' => 'Please enter your city',
            'detail_address.required' => 'Please enter your detail address',
            'zip_code.required' => 'Please enter your zip code'
        ]);
        if ($validator->fails()) {
            $arr = [
                'success' => false,
                'status' => 500,
                'message' => 'Validation failed',
                'data' => $validator->errors()
            ];
            return response()->json($arr, 500);
        }
        $address = UserAddress::where('id' , $id)->first();
        $address->country = $request->country;
        $address->city = $request->city;
        $address->detail_address = $request->detail_address;
        $address->zip_code = $request->zip_code;
        $address->save();
        $arr = [
            'status' => 200,
            'message' => "Update address sucessfully",
            'data' => $address
        ];
        return response()->json($arr, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
