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
            throw new \Exception($result['message'] ?? 'Failed to get staff data');
        } catch (\Throwable $th) {
            return response()->json([
                'message' => "Failed to get data",
                'error'   => $th->getMessage(),
            ], 500);
        }
    }

    public function create_staff(array $data)
    {
        try {
            $token    = $this->token->GetToken();
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$token}",
            ])->post("{$this->api_url}/create-staff", $data);

            $result = $response->json();

            if ($response->failed()) {
                throw new \Exception($result['message'] ?? 'Failed to create staff');
            }

            return $result;
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }

    public function update_staff(array $data, int $id)
    {
        try {
            $token    = $this->token->GetToken();
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$token}",
            ])->put("{$this->api_url}/update-staff/$id", $data);

            $result = $response->json();
            if ($response->failed()) {
                throw new \Exception($result['message'] ?? 'Failed to update staff');
            }

            return $result;
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }

    public function delete_staff(int $id)
    {
        try {
            $token    = $this->token->GetToken();
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$token}",
            ])->delete("{$this->api_url}/delete-staff/$id");

            $result = $response->json();
            if ($response->failed()) {
                throw new \Exception($result['message'] ?? 'Failed to delete staff');
            }
            return $result;
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }

    public function update_status(bool $status, int $id)
    {
        try {
            $token    = $this->token->GetToken();
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$token}",
            ])->put("{$this->api_url}/edit-status/$id", [
                'active' => $status,
            ]);
            $result = $response->json();
            if ($response->failed()) {
                throw new \Exception($result['message'] ?? 'Failed to edit staff');
            }

            return $result;
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }
}
