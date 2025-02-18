<?php
namespace App\Response;

use App\Http\Resources\VisitorCategoryResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;

class Response
{
    public static function success(string $message, mixed $data, int $status_code): JsonResponse
    {
        return response()->json([
            'success'     => true,
            'status_code' => $status_code,
            'message'     => $message,
            'data'        => $data === null ? null : (
                $data instanceof Collection || is_array($data)
                ? VisitorCategoryResource::collection($data)
                : new VisitorCategoryResource($data)
            ),
        ], $status_code);
    }

    public static function error(string $message, mixed $errors = null, int $status_code): JsonResponse
    {
        $response = [
            'success'     => false,
            'status_code' => $status_code,
            'message'     => $message,
        ];

        if ($errors !== null) {
            $response['errors'] = $errors;
        }

        return response()->json($response, $status_code);
    }
}
