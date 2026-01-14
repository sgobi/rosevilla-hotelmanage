<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.reviews.index', [
            'reviews' => Review::latest()->get(),
            'editingReview' => null,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return redirect()->route('admin.reviews.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $this->validatedData($request);

        Review::create($data);

        return redirect()->route('admin.reviews.index')->with('success', 'Review added.');
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
    public function edit(Review $review)
    {
        return view('admin.reviews.index', [
            'reviews' => Review::latest()->get(),
            'editingReview' => $review,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Review $review)
    {
        $data = $this->validatedData($request);

        $review->update($data);

        return redirect()->route('admin.reviews.index')->with('success', 'Review updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Review $review)
    {
        $review->delete();

        return back()->with('success', 'Review removed.');
    }

    protected function validatedData(Request $request): array
    {
        $data = $request->validate([
            'guest_name' => ['required', 'string', 'max:255'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['required', 'string'],
            'source' => ['nullable', 'string', 'max:120'],
            'is_published' => ['nullable', 'boolean'],
        ]);

        $data['is_published'] = $request->boolean('is_published', true);

        return $data;
    }
}
