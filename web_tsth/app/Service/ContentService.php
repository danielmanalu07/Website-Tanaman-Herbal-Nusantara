<?php
namespace App\Service;

use App\Http\Constant\ApiConstant;
use App\Http\Constant\LanguageConstant;
use App\Http\Constant\TokenConstant;
use App\Http\Resources\ContentResource;
use Illuminate\Support\Facades\Http;

class ContentService
{
    private $api_url;
    private $token, $language;

    public function __construct(TokenConstant $token, LanguageConstant $languageConstant)
    {
        $this->token    = $token;
        $this->api_url  = ApiConstant::BASE_URL;
        $this->language = $languageConstant;
    }

    public function get_all_content()
    {
        try {
            $token    = $this->token->GetToken();
            $lang     = $this->language->GetLanguage();
            $response = Http::withHeaders([
                'Authorization'   => "Bearer {$token}",
                'Accept-Language' => "{$lang}",
            ])->get("{$this->api_url}/content");

            $result = $response->json();
            if ($response->failed()) {
                return collect();
            }

            $collection = collect($result['data'])->map(function ($item) {
                return (object) $item;
            });

            return ContentResource::collection($collection);

        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }

    public function get_all_content_user()
    {
        try {
            $lang     = $this->language->GetLanguage();
            $response = Http::withHeaders([
                'Accept-Language' => "{$lang}",
            ])->get("{$this->api_url}/content-user");

            $result = $response->json();
            if ($response->failed()) {
                return collect();
            }

            $collection = collect($result['data'])->map(function ($item) {
                return (object) $item;
            });

            return ContentResource::collection($collection);

        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }

    public function get_detail_content_user(int $id)
    {
        try {
            $lang     = $this->language->GetLanguage();
            $response = Http::withHeaders([
                'Accept-Language' => "{$lang}",
            ])->get("{$this->api_url}/content-user/$id");

            $result = $response->json();
            if ($response->failed()) {
                throw new \Exception($result['message']);
            }

            return $result;

        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }

    public function upload($file)
    {
        try {
            $token    = $this->token->GetToken();
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$token}",
            ])->attach(
                'upload',
                file_get_contents($file->getRealPath()),
                $file->getClientOriginalName()
            )->post("{$this->api_url}/content/upload");

            $result = $response->json();

            if ($response->failed()) {
                throw new \Exception($result['message']);
            }

            return $result;
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }

    public function create_content(array $data)
    {
        try {
            $token    = $this->token->GetToken();
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$token}",
            ])->post("{$this->api_url}/content/create", $data);

            $result = $response->json();
            if ($response->failed()) {
                throw new \Exception($result['message']);
            }
            return $result;
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }

    public function edit_content(array $data, int $id)
    {
        try {
            $token    = $this->token->GetToken();
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$token}",
            ])->put("{$this->api_url}/content/$id/edit", $data);
            $result = $response->json();
            if ($response->failed()) {
                throw new \Exception($result['message']);
            }
            return $result;
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }

    public function delete_content(int $id)
    {
        try {
            $token    = $this->token->GetToken();
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$token}",
            ])->delete("{$this->api_url}/content/$id/delete");
            $result = $response->json();
            if ($response->failed()) {
                throw new \Exception($result['message']);
            }
            return $result;
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }

    public function update_status(bool $status, int $id)
    {
        try {
            $token    = $this->token->GetToken();
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$token}",
            ])->put("{$this->api_url}/content/$id/update-status", [
                'status' => $status,
            ]);

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
