<?php
namespace App\Service;

use App\Http\Constant\ApiConstant;
use App\Http\Constant\TokenConstant;
use App\Http\Resources\LanguageResource;
use Illuminate\Support\Facades\Http;

class LanguageService
{
    private $api_url;
    private $token;

    public function __construct(TokenConstant $token)
    {
        $this->token   = $token;
        $this->api_url = ApiConstant::BASE_URL;
    }

    public function get_all_lang()
    {
        try {
            $token    = $this->token->GetToken();
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$token}",
            ])->get("{$this->api_url}/languages");

            $result = $response->json();

            if ($response->failed()) {
                return collect();
            }
            $collection = collect($result['data'])->map(function ($item) {
                return (object) $item;
            });
            // dd($collection);
            return $collection;
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }

    public function get_all_lang_user()
    {
        try {
            $response = Http::get("{$this->api_url}/lang-user");

            $result = $response->json();

            if ($response->failed()) {
                return collect();
            }
            $collection = collect($result['data'])->map(function ($item) {
                return (object) $item;
            });
            // dd($collection);
            return $collection;
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }

    public function create_lang(array $data)
    {
        try {
            $token    = $this->token->GetToken();
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$token}",
            ])->post("{$this->api_url}/languages/create", $data);

            $result = $response->json();
            if ($response->failed()) {
                return $result;
            }
            return $result;
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }

    public function edit_lang(array $data, int $id)
    {
        try {
            $token    = $this->token->GetToken();
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$token}",
            ])->put("{$this->api_url}/languages/$id/edit", $data);

            $result = $response->json();

            if ($response->failed()) {
                throw new \Exception($result['message']);
            }

            return new LanguageResource($result);

        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }

    public function delete_lang(int $id)
    {
        try {
            $token    = $this->token->GetToken();
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$token}",
            ])->delete("{$this->api_url}/languages/$id/delete");

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
