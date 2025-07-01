<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|unique:users,name,' . $this->route('user')->id . '|max:255',
            'email' => 'required|email|unique:users,email,' . $this->user()->id,
        ];
    }
}
