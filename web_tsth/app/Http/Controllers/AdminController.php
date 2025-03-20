<?php
namespace App\Http\Controllers;

use App\Http\Constant\ApiConstant;
use App\Http\Constant\TokenConstant;

class AdminController extends Controller
{
    private $api_url;
    private $token;

    public function __construct(TokenConstant $token)
    {
        $this->api_url = ApiConstant::BASE_URL;
        $this->token   = $token;

    }
}
