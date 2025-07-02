<?php

// app/Http/Controllers/PostController.php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Services\PostService;
use App\Http\Requests\StorePostRequest;
use App\Http\Resources\PostResource;

class PostController extends Controller
{
    protected PostService $service;

    public function __construct(PostService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $posts = Post::with(['user', 'category', 'children', 'likes'])->latest()->get();
        return PostResource::collection($posts);
    }

    public function store(StorePostRequest $request)
    {
        $post = $this->service->create($request->validated());
        return new PostResource($post);
    }

    public function show(Post $post)
    {
        $post->load(['user', 'category', 'children', 'likes']);
        return new PostResource($post);
    }

    public function update(StorePostRequest $request, Post $post)
    {
        $this->authorize('update', $post); // optional policy
        $post = $this->service->update($post, $request->validated());
        return new PostResource($post);
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
        $this->service->delete($post);
        return response()->json(null, 204);
    }

    public function myPosts()
{
    $posts = auth()->user()->posts()->with(['category', 'likes'])->latest()->get();
    return PostResource::collection($posts);
}


public function likedPosts()
{
    $user = auth()->user();
    $posts = $user->likes()->with('post.user', 'post.category', 'post.likes')->get()->pluck('post');
    return PostResource::collection($posts);
}

}
