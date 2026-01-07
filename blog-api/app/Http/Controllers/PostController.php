<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Post::with(['category:id,name', 'author:id,name']);

        if ($request->has('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        if ($request->has('author')) {
            $query->where('user_id', $request->author);
        }

        if ($request->boolean('published')) {
            $query->whereNotNull('published_at');
        }

        return PostResource::collection(
            $query->latest()->paginate(15)
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        $postResource = new PostResource(
            resource: Post::query()->create(
                attributes: $request->validated()
            ),
        );
        return $postResource->response()->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        try {
            return new PostResource(
                resource: Post::query()
                    ->with(['author:id,name', 'category:id,name'])
                    ->findOrFail($post->id)
            );
        } catch (ModelNotFoundException) {
            return response()->json([
                'message' => 'Post not found'
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $post->update($request->validated());

        return new PostResource($post);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();

        return response()->noContent();
    }
}
