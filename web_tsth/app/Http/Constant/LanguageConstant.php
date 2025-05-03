<?php
namespace App\Http\Constant;

class LanguageConstant
{
    public static function GetLanguage()
    {
        return session('app_language', 'id');
    }

    public static function SetLanguage($language)
    {
        return session(['app_language' => $language]);
    }

    public static function GetLanguageUser()
    {
        return session('app_language_user', 'id');
    }

    public static function SetLanguageUser($language)
    {
        return session(['app_language_user' => $language]);
    }
}
