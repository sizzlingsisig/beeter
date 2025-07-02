<?php

// app/Http/Requests/StorePostRequest.php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'nullable|string|max:255',
            'content' => 'required|string',
            'category_id' => 'nullable|exists:categories,id',
            'parent_id' => 'nullable|exists:posts,id',
        ];
    }
}
