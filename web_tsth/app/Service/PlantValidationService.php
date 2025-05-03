<?php
namespace App\Service;

use App\Http\Constant\ApiConstant;
use App\Http\Constant\LanguageConstant;
use App\Http\Constant\TokenConstant;
use Illuminate\Support\Facades\Http;

class PlantValidationService
{
    private $api_url;
    private $token, $language;

    public function __construct(TokenConstant $token, LanguageConstant $language)
    {
        $this->api_url  = ApiConstant::BASE_URL;
        $this->token    = $token;
        $this->language = $language;
    }

    public function get_all_validation()
    {
        try {
            $token    = $this->token->GetToken();
            $lang     = $this->language->GetLanguage();
            $response = Http::withHeaders([
                'Authorization'   => "Bearer {$token}",
                'Accept-Language' => "{$lang}",
            ])->get("{$this->api_url}/validated");

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

}
