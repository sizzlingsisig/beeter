<?php
// app/Http/Controllers/LikeController.php
namespace App\Http\Controllers;

use App\Http\Requests\StoreLikeRequest;
use App\Http\Resources\LikeResource;
use App\Services\LikeService;

class LikeController extends Controller
{
    protected $service;

    public function __construct(LikeService $service)
    {
        $this->service = $service;
    }

    public function store(StoreLikeRequest $request)
    {
        $like = $this->service->toggleLike($request->post_id);

        if (!$like) {
            return response()->json(['message' => 'Unliked successfully.'], 200);
        }

        return new LikeResource($like);
    }
}
