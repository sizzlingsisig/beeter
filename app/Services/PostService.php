<?php

namespace App\Services;

use App\Models\Post;

class PostService
{
    public function create(array $data): Post
    {
        return Post::create([
            ...$data,
            'user_id' => auth()->id(),
        ]);
    }

    public function update(Post $post, array $data): Post
    {
        $post->update($data);
        return $post;
    }

    public function delete(Post $post): bool
    {
        return $post->delete();
    }
}
