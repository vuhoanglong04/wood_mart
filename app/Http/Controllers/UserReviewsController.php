<?php

namespace App\Http\Controllers;

use App\Models\UserReviews;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class UserReviewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!Gate::allows('reviews.view')) {
            abort(404);
        }
        $reviews = UserReviews::withTrashed()->get();
        return view('reviews.list', compact('reviews'));
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
        //
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $review = UserReviews::withTrashed()->find($id);
        $review->forceDelete();
        return true;
    }
    public function softDelete(string $id)
    {
        $review = UserReviews::withTrashed()->find($id);
        $review->delete();
        return true;
    }
    public function restore(string $id)
    {
        $review = UserReviews::withTrashed()->find($id);
        $review->restore();
        return true;
    }
}
