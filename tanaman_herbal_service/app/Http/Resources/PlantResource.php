<?php
namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PlantResource extends JsonResource
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
            'name'                => $this->name,
            'latin_name'          => $this->latin_name,
            'advantage'           => $this->advantage,
            'ecology'             => $this->ecology,
            'endemic_information' => $this->endemic_information,
            'qrcode'              => $this->qrcode ? asset("storage/{$this->qrcode}") : null,
            'status'              => $this->status ? true : false,
            'habitus'             => new HabitusResource($this->habitus),
            'created_by'          => optional($this->createdBy)->username,
            'updated_by'          => optional($this->createdBy)->username,
            "created_at"          => Carbon::parse($this->created_at)->translatedFormat('d F Y h:i A'),
            "updated_at"          => Carbon::parse($this->updated_at)->translatedFormat('d F Y h:i A'),
            'deleted_at'          => Carbon::parse($this->created_at)->translatedFormat('d F Y h:i A'),
        ];
    }
}
