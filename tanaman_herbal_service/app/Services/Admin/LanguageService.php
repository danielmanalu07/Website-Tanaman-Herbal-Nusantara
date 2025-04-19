<?php
namespace App\Services\Admin;

use App\Http\Repositories\LanguageRepository;
use App\Response\Response;
use Illuminate\Support\Facades\Auth;

class LanguageService
{
    private $language_repository;
    public function __construct(LanguageRepository $language_repository)
    {
        $this->language_repository = $language_repository;
    }

    public function create_lang(array $data)
    {
        try {
            $admin = Auth::user();

            $language = $this->language_repository->create([
                'name'       => $data['name'],
                'code'       => $data['code'],
                'created_by' => $admin->id,
                'updated_by' => $admin->id,
            ]);
            return $language;
        } catch (\Throwable $th) {
            return Response::error('Failed to create data language', $th->getMessage(), 500);
        }
    }

    public function get_all_lang()
    {
        try {
            $languages = $this->language_repository->get_all();
            if ($languages == null) {
                return Response::error('Data not found', null, 404);
            }

            return $languages;
        } catch (\Throwable $th) {
            return Response::error('Failed to get data language', $th->getMessage(), 500);
        }
    }

    public function get_detail_lang(int $id)
    {
        try {
            $language = $this->language_repository->get_detail($id);
            if (! $language) {
                return Response::error('data not found', null, '404');
            }
            return $language;
        } catch (\Throwable $th) {
            return Response::error('Failed to get data language', $th->getMessage(), 500);
        }
    }

    public function update_lang(int $id, array $data)
    {
        try {
            $admin    = Auth::user();
            $language = $this->language_repository->update($id, [
                'name'       => $data['name'],
                'code'       => $data['code'],
                'updated_by' => $admin->id,
            ]);
            return $language;
        } catch (\Throwable $th) {
            return Response::error('Failed to update data language', $th->getMessage(), 500);
        }
    }

    public function delete_lang(int $id)
    {
        try {
            $language = $this->language_repository->delete($id);
            if (! $language) {
                return Response::error('Data not found', null, 404);
            }
            return $language;
        } catch (\Throwable $th) {
            return Response::error('Failed to delete data language', $th->getMessage(), 500);
        }

    }
}
