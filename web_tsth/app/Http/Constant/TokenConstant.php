<?php
namespace App\Http\Constant;

class TokenConstant
{
    public static function SetToken($token)
    {
        session(['token' => $token]);
    }

    public static function GetToken()
    {
        return session('token');
    }

    public static function RemoveToken()
    {
        session()->forget('token');
    }
}
