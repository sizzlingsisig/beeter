<?php

// app/Http/Resources/PostResource.php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
   // app/Http/Resources/PostResource.php
public function toArray($request)
{
    return [
        'id' => $this->id,
        'title' => $this->title,
        'content' => $this->content,
        'likes_count' => $this->likes()->count(),
        'liked_by_user' => $request->user()
            ? $this->likes()->where('user_id', $request->user()->id)->exists()
            : false,
        'created_at' => $this->created_at,
        'user' => new UserResource($this->whenLoaded('user')),
        'category' => new CategoryResource($this->whenLoaded('category')),
    ];
}

}
