<?php
// app/Services/LikeService.php
namespace App\Services;

use App\Models\Like;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class LikeService
{
    public function toggleLike(int $postId)
    {
        $user = Auth::user();

        $like = Like::where('user_id', $user->id)
                    ->where('post_id', $postId)
                    ->first();

        if ($like) {
            $like->delete();
            return null;
        }

        return Like::create([
            'user_id' => $user->id,
            'post_id' => $postId,
        ]);
    }
}
