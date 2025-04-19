<?php
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LanguageResource extends JsonResource
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
            'name'       => $this->name,
            'code'       => $this->code,
            'created_by' => $this->createdBy,
            'updated_by' => $this->createdBy,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
            'deleted_at' => $this->delated_at,
        ];
    }
}
