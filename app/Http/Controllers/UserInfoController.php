<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserInfoRequest;
use App\Http\Resources\UserInfoResource;
use App\Models\UserInfo;
use App\Services\UserInfoService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Exception;

class UserInfoController extends Controller
{
    public function store(StoreUserInfoRequest $request, UserInfoService $service)
    {
        try {
            $info = $service->store(Auth::id(), $request->validated());
            return new UserInfoResource($info);
        } catch (Exception $e) {
            return response()->json(['message' => 'Failed to create user info'], 500);
        }
    }

    public function update(StoreUserInfoRequest $request, UserInfoService $service)
    {
        try {
            $info = Auth::user()->userInfo;
            if (!$info) return response()->json(['message' => 'User info not found'], 404);

            $updated = $service->update($info, $request->validated());
            return new UserInfoResource($updated);
        } catch (Exception $e) {
            return response()->json(['message' => 'Failed to update user info'], 500);
        }
    }

    public function show(UserInfoService $service)
    {
        $userId = auth()->id();
        $info = $service->show($userId);

        if (!$info) {
            return response()->json(['message' => 'User info not found'], 404);
        }

        return new UserInfoResource($info);
    }

    /**
     * Return user name, nickname, bio, and amount of posts
     */
    public function summary()
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'User not authenticated'], 401);
        }

        $userInfo = $user->userInfo;
        $nickname = $userInfo ? $userInfo->nickname : null;
        $bio = $userInfo ? $userInfo->bio : null;

        // Assuming you have a posts() relationship set up on the User model
        $postsCount = $user->posts()->count();

        return response()->json([
            'name' => $user->name,
            'nickname' => $nickname,
            'bio' => $bio,
            'posts_count' => $postsCount,
        ]);
    }
}
