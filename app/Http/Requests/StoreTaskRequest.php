<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Auth handled by sanctum middleware
    }

    public function rules(): array
    {
        return [
            'title'          => 'required|string|max:255',
            'description'    => 'nullable|string',
            'priority'       => 'required|in:low,medium,high',
            'due_date'       => 'nullable|date',
            'category_ids'   => 'nullable|array',
            'category_ids.*' => 'exists:categories,id',
        ];
    }
}
