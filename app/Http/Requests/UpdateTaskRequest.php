<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Ownership check is done in TaskService
    }

    public function rules(): array
    {
        return [
            'title'          => 'sometimes|string|max:255',
            'description'    => 'nullable|string',
            'priority'       => 'sometimes|in:low,medium,high',
            'due_date'       => 'nullable|date',
            'status'         => 'sometimes|in:pending,in_progress,completed',
            'category_ids'   => 'nullable|array',
            'category_ids.*' => 'exists:categories,id',
        ];
    }
}
