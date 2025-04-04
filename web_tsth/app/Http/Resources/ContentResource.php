<?php
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            'key'        => $this->key,
            'title'      => $this->title,
            'content'    => $this->content,
            'status'     => $this->status,
            'created_by' => $this->createdBy,
            'updated_by' => $this->createdBy,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
            'deleted_at' => $this->created_at,
        ];
    }
}
