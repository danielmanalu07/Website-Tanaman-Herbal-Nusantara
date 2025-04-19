<?php
namespace App\Service;

use App\Http\Constant\ApiConstant;
use App\Http\Constant\LanguageConstant;
use App\Http\Constant\TokenConstant;

class OurGardenService
{
    private $api_url;
    private $token, $language;

    public function __construct(TokenConstant $token, LanguageConstant $language)
    {
        $this->token    = $token;
        $this->api_url  = ApiConstant::BASE_URL;
        $this->language = $language;
    }

}
