<?php

namespace App\Services;

use App\Models\UserInfo;
use App\Models\User;

class UserInfoService
{
    public function store(int $userId, array $data): UserInfo
    {
        return UserInfo::create(array_merge($data, ['user_id' => $userId]));
    }

    public function update(UserInfo $info, array $data): UserInfo
    {
        $info->update($data);
        return $info;
    }

    public function show(int $userId): ?UserInfo
{
return UserInfo::where('user_id', $userId)
    ->latest('created_at')
    ->with('user')
    ->first();
}

}   
