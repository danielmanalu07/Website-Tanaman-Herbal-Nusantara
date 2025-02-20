<?php
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VisitorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if (is_null($this->resource)) {
            return [];
        }

        return [
            'id'                  => $this->id,
            'visitor_total'       => $this->visitor_total,
            'visitor_category_id' => $this->visitor_category->name,
            'created_by'          => optional($this->createdBy)->username,
            'updated_by'          => optional($this->createdBy)->username,
            'created_at'          => $this->created_at,
            'updated_at'          => $this->updated_at,
            'deleted_at'          => $this->deleted_at,
        ];
    }
}
