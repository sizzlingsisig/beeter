<?php

// app/Http/Requests/StoreLikeRequest.php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLikeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'post_id' => 'required|exists:posts,id',
        ];
    }
}
