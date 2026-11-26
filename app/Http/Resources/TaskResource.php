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
            'priority'    => $this->priority,
            'status'      => $this->status,
            'due_date'    => $this->due_date ? \Carbon\Carbon::parse($this->due_date)->toDateString() : null,
            'is_overdue'  => $this->isOverdue(),
            'category_id' => $this->category_id,
            'category'    => new CategoryResource($this->whenLoaded('category')),
            'created_at'  => $this->created_at->toDateString(),
        ];
    }
}