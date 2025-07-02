<?php

// app/Http/Resources/LikeResource.php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LikeResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user' => new UserResource($this->whenLoaded('user')),
            'post_id' => $this->post_id,
            'created_at' => $this->created_at,
        ];
    }
}
