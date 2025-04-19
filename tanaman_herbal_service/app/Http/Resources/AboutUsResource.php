<?php
namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AboutUsResource extends JsonResource
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

        $translation = $this->languages()
            ->where('language_id', currentLanguageId())
            ->first();

        return [
            'id'         => $this->id,
            'title'      => $translation ? $translation->pivot->title : $this->title,
            'text'       => $translation ? $translation->pivot->text : $this->text,
            'created_by' => optional($this->createdBy)->username,
            'updated_by' => optional($this->createdBy)->username,
            "created_at" => Carbon::parse($this->created_at)->translatedFormat('d F Y h:i A'),
            "updated_at" => Carbon::parse($this->updated_at)->translatedFormat('d F Y h:i A'),
            'deleted_at' => Carbon::parse($this->created_at)->translatedFormat('d F Y h:i A'),
        ];
    }
}
