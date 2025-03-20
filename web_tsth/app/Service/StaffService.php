<?php
namespace App\Service;

use App\Http\Constant\ApiConstant;
use App\Http\Constant\TokenConstant;
use App\Http\Resources\StaffResource;
use Illuminate\Support\Facades\Http;

class StaffService
{
    private $api_url;
    private $token;

    public function __construct(TokenConstant $token)
    {
        $this->api_url = ApiConstant::BASE_URL;
        $this->token   = $token;
    }

    public function get_all_staff()
    {
        try {
            $token    = $this->token->GetToken();
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$token}",
            ])->get("{$this->api_url}/get-staff");

            $result = $response->json();

            if ($response->successful() && isset($result['status_code']) && $result['status_code'] === 200) {
                $collection = collect($result['data'])->map(function ($item) {
                    return (object) $item;
                });
                return StaffResource::collection($collection);
            }
            return collect();
        } catch (\Throwable $th) {
            return response()->json([
                'message' => "Failed to get data",
                'error'   => $th->getMessage(),
            ], 500);
        }
    }

    public function create_staff(array $data)
    {
        $token    = $this->token->GetToken();
        $response = Http::withHeaders([
            'Authorization' => "Bearer {$token}",
        ])->post("{$this->api_url}/create-staff", [
            'full_name' => $data['full_name'],
            'email'     => $data['email'],
            'phone'     => $data['phone'],
            'username'  => $data['username'],
            'password'  => $data['password'],
            'role'      => $data['role'],
        ]);

        $result = $response->json();
        if ($response->failed()) {
            return $result['message'];
        }
        return $result;

    }
}
