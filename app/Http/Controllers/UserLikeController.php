<?php

public function likedPosts()
{
    $user = auth()->user();
    $posts = $user->likes()->with('post')->get()->pluck('post')->filter();

    return PostResource::collection($posts);
}
