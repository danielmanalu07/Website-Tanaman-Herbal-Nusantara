<?php
namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ValidationResource extends JsonResource
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
            'id'              => $this->id,
            'description'     => $this->description,
            'date_validation' => $this->date_validation,
            'condition'       => $this->condition,
            'plant'           => $this->plants,
            'validator'       => $this->users,
            'images'          => ImageResource::collection($this->images),
            "created_at"      => Carbon::parse($this->created_at)->translatedFormat('d F Y h:i A'),
            "updated_at"      => Carbon::parse($this->updated_at)->translatedFormat('d F Y h:i A'),
        ];
    }
}
