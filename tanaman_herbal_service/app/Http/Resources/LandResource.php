<?php
namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LandResource extends JsonResource
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
            'id'         => $this->id,
            'name'       => $this->name,
            'created_by' => optional($this->createdBy)->username,
            'updated_by' => optional($this->createdBy)->username,
            'created_at' => Carbon::parse($this->created_at)->translatedFormat('d F Y h:i A'),
            'updated_at' => Carbon::parse($this->updated_at)->translatedFormat('d F Y h:i A'),
            'deleted_at' => Carbon::parse($this->created_at)->translatedFormat('d F Y h:i A'),
        ];
    }
}
