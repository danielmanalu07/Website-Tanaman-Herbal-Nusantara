<?php
namespace App\Http\Repositories;

use App\Models\User;

class UserRepository
{
    public function update_status(int $id, bool $active)
    {
        $user = User::findOrFail($id);
        $user->update([
            'active' => $active,
        ]);
        return $user;
    }
}
