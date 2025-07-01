<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DestroyCategoryRequest extends FormRequest
{
 public function authorize(): bool
    {
        // Authorization is handled by middleware, so just return true
        return true;
    }


    public function rules(): array
    {
        return [];
    }
}
