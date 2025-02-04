<?php
namespace App\Exceptions;

use Exception;
use Throwable;

class Handler extends Exception
{
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof \Spatie\Permission\Exceptions\UnauthorizedException) {
            return response()->json([
                'message' => 'You do not have the required permissions.',
            ], 403);
        }

        return parent::render($request, $exception);
    }
}
