<?php
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserProfileResource extends JsonResource
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
            'username'    => $this->username,
            'roles'       => $this->roles,
            'permissions' => $this->permissions,
            "created_at"  => $this->created_at,
            "updated_at"  => $this->updated_at,
            "created_by"  => $this->createdBy,
            "updated_by"  => $this->updatedBy,
            "deleted_at"  => $this->deleted_at,
        ];
    }
}
