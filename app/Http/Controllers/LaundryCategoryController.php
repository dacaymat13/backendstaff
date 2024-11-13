<?php

namespace App\Http\Controllers;

use App\Models\LaundryCategory;
use Illuminate\Http\Request;

class LaundryCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'Category' => "required|max:50",
            'Price' => "required|max:255",
        ]);

        $data = $request->all();

        $categ = LaundryCategory::create($data);

        $categList = LaundryCategory::orderBy('created_at', 'desc')->get();

        return response()->json([
            'message' => 'Customer added successfully',
            'Category' => $categ,
            'Category List' => $categList
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(LaundryCategory $laundryCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLaundryCategoryRequest $request, LaundryCategory $laundryCategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LaundryCategory $laundryCategory)
    {
        //
    }
}
