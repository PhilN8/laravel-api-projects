<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use App\Http\Requests\StoreBookmarkRequest;
use App\Http\Requests\UpdateBookmarkRequest;
use App\Http\Resources\BookmarkResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class BookmarkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return BookmarkResource::collection(
            resource: $request->user()->bookmarks()->paginate()
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookmarkRequest $request)
    {
        $bookmark = new BookmarkResource(
            resource: $request->user()->bookmarks()->create(
                attributes: $request->validated()
            )
        );

        return $bookmark->response()->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Bookmark $bookmark)
    {
        try {
            return new BookmarkResource(
                resource: Bookmark::query()->findOrFail($bookmark->id)
            );
        } catch (ModelNotFoundException) {
            return response()->json([
                'message' => 'Bookmark not found'
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBookmarkRequest $request, Bookmark $bookmark)
    {
        Gate::authorize('update', $bookmark);

        $bookmark->update($request->validated());

        return new BookmarkResource($bookmark);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bookmark $bookmark)
    {
        $bookmark->delete();

        return response()->noContent();
    }
}
