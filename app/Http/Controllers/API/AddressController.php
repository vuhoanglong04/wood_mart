<?php

namespace App\Http\Controllers\API;

use App\Models\Address;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
       if($request->user_id){
         return Address::where('user_id',$request->user_id)->get();   
       } 
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
        $input = $request->all();
        $validator = Validator::make($input,  [
            'country' => "required",
            'city' => "required",
            'street_address' => "required",
            'post_code' => "required",
        ],
        [
            'country.required' => "Please enter your country",
            'city.required' => "Please enter your city",
            'street_address.required' => "Please enter your street_address",
            'post_code.required' => "Please enter your post_code",

        ]);
        if ($validator->fails()) {
            $arr = [
                'success' => false,
                'status' => 422,
                'message' => 'Validation failed',
                'data' => $validator->errors()
            ];
            return response()->json($arr, 422);
        }
        $newAddress = new Address();
        $newAddress->user_id  = $request->user_id;
        $newAddress->country = $request->country;
        $newAddress->city = $request->city;
        $newAddress-> street_address = $request->street_address;
        $newAddress->post_code = $request->post_code;
        $newAddress->save();
        $arr = [
            'status' => 201,
            'message' => "Create address sucessfully",
            'data' => $newAddress
        ];
        return response()->json($arr, 201);
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input,  [
            'country' => "required",
            'city' => "required",
            'street_address' => "required",
            'post_code' => "required",
        ],
        [
            'country.required' => "Please enter your country",
            'city.required' => "Please enter your city",
            'street_address.required' => "Please enter your street_address",
            'post_code.required' => "Please enter your post_code",

        ]);
        if ($validator->fails()) {
            $arr = [
                'success' => false,
                'status' => 422,
                'message' => 'Validation failed',
                'data' => $validator->errors()
            ];
            return response()->json($arr, 422);
        }
        $address = Address::where('user_id' , $request->user_id)->first();
        $address->user_id  = $request->user_id;
        $address->country = $request->country;
        $address->city = $request->city;
        $address-> street_address = $request->street_address;
        $address->post_code = $request->post_code;
        $address->save();
        $arr = [
            'status' => 200,
            'message' => "Update address sucessfully",
            'data' => $address
        ];
        return response()->json($arr, 200);
    }
    public function destroy(string $id)
    {
        //
    }
}
