<?php
namespace App\Service;

use App\Http\Constant\ApiConstant;
use App\Http\Constant\LanguageConstant;
use App\Http\Constant\TokenConstant;
use Illuminate\Support\Facades\Http;

class ContactUsService
{
    private $api_url;
    private $token, $language;

    public function __construct(TokenConstant $token, LanguageConstant $language_constant)
    {
        $this->token    = $token;
        $this->api_url  = ApiConstant::BASE_URL;
        $this->language = $language_constant;
    }

    public function get_all_contact()
    {
        try {
            $token    = $this->token->GetToken();
            $lang     = $this->language->GetLanguage();
            $response = Http::withHeaders([
                'Authorization'   => "Bearer {$token}",
                'Accept-Language' => "{$lang}",
            ])->get("{$this->api_url}/contact-us");
            $result = $response->json();
            if ($response->failed()) {
                return collect();
            }
            $collection = collect($result['data'])->map(function ($item) {
                return (object) $item;
            });
            return $collection;
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }

    public function get_all_contact_user()
    {
        try {
            $lang     = $this->language->GetLanguage();
            $response = Http::withHeaders([
                'Accept-Language' => "{$lang}",
            ])->get("{$this->api_url}/contact-us-user");
            $result = $response->json();
            if ($response->failed()) {
                return collect();
            }
            $collection = collect($result['data'])->map(function ($item) {
                return (object) $item;
            });
            return $collection;
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
            )->post("{$this->api_url}/contact-us/upload");

            $result = $response->json();

            if ($response->failed()) {
                throw new \Exception($result['message']);
            }

            return $result;
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }

    public function create_contact(array $data)
    {
        try {
            $token    = $this->token->GetToken();
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$token}",
            ])->post("{$this->api_url}/contact-us/create", $data);

            $result = $response->json();
            if ($response->failed()) {
                throw new \Exception($result['message']);
            }

            return $result;
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }

    public function edit_contact(array $data, int $id)
    {
        try {
            $token    = $this->token->GetToken();
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$token}",
            ])->put("{$this->api_url}/contact-us/$id/edit", $data);
            $result = $response->json();
            if ($response->failed()) {
                throw new \Exception($result['message']);
            }
            return $result;
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }

    public function delete_contact(int $id)
    {
        try {
            $token    = $this->token->GetToken();
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$token}",
            ])->delete("{$this->api_url}/contact-us/$id/delete");
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
