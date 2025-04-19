<?php
namespace App\Service;

use App\Http\Constant\ApiConstant;
use App\Http\Constant\LanguageConstant;
use App\Http\Constant\TokenConstant;
use App\Http\Resources\VisitorCategoryResource;
use Illuminate\Support\Facades\Http;

class VisitorCategoryService
{
    private $api_url;
    private $token, $language;

    public function __construct(TokenConstant $token, LanguageConstant $language_constant)
    {
        $this->api_url  = ApiConstant::BASE_URL;
        $this->token    = $token;
        $this->language = $language_constant;
    }

    public function get_all_visitor_category()
    {
        try {
            $lang     = $this->language->GetLanguage();
            $token    = $this->token->GetToken();
            $response = Http::withHeaders([
                'Authorization'   => "Bearer {$token}",
                'Accept-Language' => "{$lang}",
            ])->get("{$this->api_url}/visitor-categories");

            $result = $response->json();
            if ($response->failed()) {
                return collect();
            }
            $collection = collect($result['data'])->map(function ($item) {
                return (object) $item;
            });

            return VisitorCategoryResource::collection($collection);
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }

    public function create_visitor_category(string $name)
    {
        try {
            $token    = $this->token->GetToken();
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$token}",
            ])->post("{$this->api_url}/visitor-category", [
                'name' => $name,
            ]);

            $result = $response->json();
            if ($response->failed()) {
                throw new \Exception($result['message']);
            }

            return new VisitorCategoryResource($result);
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }

    public function update_visitor_category(string $name, int $id)
    {
        try {
            $token    = $this->token->GetToken();
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$token}",
            ])->put("{$this->api_url}/visitor-category/$id", [
                'name' => $name,
            ]);

            $result = $response->json();

            if ($response->failed()) {
                throw new \Exception($result['message']);
            }

            return new VisitorCategoryResource($result);

        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }

    public function delete_visitor_category(int $id)
    {
        try {
            $token    = $this->token->GetToken();
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$token}",
            ])->delete("{$this->api_url}/visitor-category/$id");

            $result = $response->json();

            if ($response->failed()) {
                throw new \Exception($result['message']);
            }

            return $result;
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }

}
