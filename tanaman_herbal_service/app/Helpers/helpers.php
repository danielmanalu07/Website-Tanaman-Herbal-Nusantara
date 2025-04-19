<?php

if (! function_exists('currentLanguage')) {
    function currentLanguage()
    {
        return app('current_language');
    }
}

if (! function_exists('currentLanguageId')) {
    function currentLanguageId()
    {
        return app('current_language')?->id;
    }
}

if (! function_exists('currentLanguageCode')) {
    function currentLanguageCode()
    {
        return app('current_language')?->code;
    }
}
