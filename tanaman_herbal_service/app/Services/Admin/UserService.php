<?php
namespace App\Services\Admin;

use App\Http\Repositories\UserRepository;
use App\Models\User;
use App\Response\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;

class UserService
{
    protected $user_repository;

    public function __construct(UserRepository $user_repository)
    {
        $this->user_repository = $user_repository;
    }

    public function update_status(int $id, bool $active)
    {
        try {
            $admin = Auth::user();
            $user  = User::findOrFail($id);

            $updateData = [
                'active'     => $active,
                'updated_by' => $admin->id,
            ];

            $result = $this->user_repository->update_status($id, $active);

            return $result;
        } catch (ModelNotFoundException $e) {
            return Response::error('Data not found', $e->getMessage(), 404);
        } catch (\Throwable $th) {
            return Response::error('Failed to update user data', $th->getMessage(), 500);
        }
    }
}
