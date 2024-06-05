<?php

namespace App\Http\Controllers\API;

use App\Models\UserReviews;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class UserReviewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return UserReviews::where('product_id', $request->product_id)->get();
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
        $validator = Validator::make($input, [
            'stars' => "required",
            'comment' => "required | min:10 | max:255",
        ], [
            'stars.required' => "Please choose rating for this product",
            'comment.required' => "You was not entered a rating for this product",
            'comment.min' => "Please enter more than 10 characters",
            'comment.max' => "Your rating is too long"
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
        $newReview = new UserReviews();
        $newReview->user_id = $request->user_id;
        $newReview->product_id = $request->product_id;
        $newReview->stars = $request->stars;
        $newReview->comment  = $request->comment;
        $newReview->save();
        $arr = [
            'status' => 201,
            'message' => 'Add review successfully',
            'data' => $newReview
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

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'stars' => "required",
            'comment' => "required | min:10 | max:255",
        ], [
            'stars.required' => "Please choose rating for this product",
            'comment.required' => "You was not entered a rating for this product",
            'comment.min' => "Please enter more than 10 characters",
            'comment.max' => "Your rating is too long"
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
        $review = UserReviews::find($id);
        $review->stars = $request->stars;
        $review->comment  = $request->comment;
        $review->save();
        $arr = [
            'status' => 200,
            'message' => 'Update review successfully',
            'data' => $review
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
