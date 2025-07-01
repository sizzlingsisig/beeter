<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserInfoRequest;
use App\Http\Resources\UserInfoResource;
use App\Models\UserInfo;
use App\Services\UserInfoService;
use Illuminate\Support\Facades\Auth;
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

}
