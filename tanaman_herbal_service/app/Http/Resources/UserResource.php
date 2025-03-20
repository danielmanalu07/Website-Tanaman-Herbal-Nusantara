<?php
namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'full_name'   => $this->full_name,
            'email'       => $this->email,
            'phone'       => $this->phone,
            'username'    => $this->username,
            'roles'       => $this->getRoleNames(),
            'permissions' => $this->getAllPermissions()->pluck('name'),
            'active'      => $this->active ? 'true' : 'false',
            "created_at"  => Carbon::parse($this->created_at)->translatedFormat('d F Y h:i A'),
            "updated_at"  => Carbon::parse($this->updated_at)->translatedFormat('d F Y h:i A'),
            "created_by"  => optional($this->createdBy)->username,
            "updated_by"  => optional($this->updatedBy)->username,
            "deleted_at"  => Carbon::parse($this->deleted_at)->translatedFormat('d F Y h:i A'),
        ];
    }
}
