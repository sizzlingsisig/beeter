<?php
namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;
use Exception;

class UserController extends Controller
{
    public function update(UpdateUserRequest $request, UserService $service)
    {
        try {
            $user = Auth::user();
            $updatedUser = $service->update($user, $request->validated());

            return new UserResource($updatedUser);
        } catch (Exception $e) {
            return response()->json(['message' => 'User update failed'], 500);
        }
    }
}
