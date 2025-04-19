<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\LanguageResource;
use App\Response\Response;
use App\Services\Admin\LanguageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    protected $language_service;
    public function __construct(LanguageService $language_service)
    {
        $this->language_service = $language_service;
    }

    public function create_lang(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'code' => 'required|string',
        ]);
        try {
            $lang = $this->language_service->create_lang($request->all());
            if ($lang instanceof JsonResponse) {
                return $lang;
            }

            return Response::success('Created language successfully', new LanguageResource($lang), 201);
        } catch (\Throwable $th) {
            return Response::error('internal server error', $th->getMessage(), 500);
        }
    }

    public function get_all_lang()
    {
        try {
            $languages = $this->language_service->get_all_lang();
            if ($languages instanceof JsonResponse) {
                return $languages;
            }
            return Response::success('Get all data successfully', LanguageResource::collection($languages), 200);
        } catch (\Throwable $th) {
            return Response::error('internal server error', $th->getMessage(), 500);
        }
    }

    public function get_detail_lang(int $id)
    {
        try {
            $language = $this->language_service->get_detail_lang($id);
            if ($language instanceof JsonResponse) {
                return $language;
            }
            return Response::success('Get data successfully', new LanguageResource($language), 200);
        } catch (\Throwable $th) {
            return Response::error('internal server error', $th->getMessage(), 500);
        }
    }

    public function update_lang(Request $request, int $id)
    {
        $request->validate([
            'name' => 'required|string',
            'code' => 'required|string',
        ]);
        try {
            $language = $this->language_service->update_lang($id, $request->all());
            if ($language instanceof JsonResponse) {
                return $language;
            }
            return Response::success('Update data successfully', new LanguageResource($language), 200);
        } catch (\Throwable $th) {
            return Response::error('internal server error', $th->getMessage(), 500);
        }
    }

    public function delete_lang(int $id)
    {
        try {
            $language = $this->language_service->delete_lang($id);
            if ($language instanceof JsonResponse) {
                return $language;
            }
            return Response::success('Delete data successfully', new LanguageResource($language), 200);
        } catch (\Throwable $th) {
            return Response::error('internal server error', $th->getMessage(), 500);
        }
    }
}
