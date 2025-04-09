<?php
namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NewsResource extends JsonResource
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
            'title'      => $this->title,
            'content'    => $this->content,
            'status'     => $this->status ? true : false,
            'published'  => $this->published_at ? Carbon::parse($this->published_at)->translatedFormat('d F Y h:i A') : null,
            'images'     => ImageResource::collection($this->images),
            'created_by' => optional($this->createdBy)->username,
            'updated_by' => optional($this->createdBy)->username,
            "created_at" => Carbon::parse($this->created_at)->translatedFormat('d F Y h:i A'),
            "updated_at" => Carbon::parse($this->updated_at)->translatedFormat('d F Y h:i A'),
            'deleted_at' => Carbon::parse($this->created_at)->translatedFormat('d F Y h:i A'),
        ];
    }
}
