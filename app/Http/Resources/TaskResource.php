<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'title'       => $this->title,
            'description' => $this->description,
            'status'      => $this->status,
            'priority'    => $this->priority,
            'due_date'    => $this->due_date,
            'user_id'     => $this->user_id,
            'categories'  => $this->whenLoaded('categories', function () {
                return $this->categories->map(fn($c) => [
                    'id'   => $c->id,
                    'name' => $c->name,
                    'slug' => $c->slug,
                ]);
            }),
            'created_at'  => $this->created_at?->toDateTimeString(),
            'updated_at'  => $this->updated_at?->toDateTimeString(),
        ];
    }
}
