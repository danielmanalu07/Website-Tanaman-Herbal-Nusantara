<?php
namespace App\Service;

use App\Http\Constant\ApiConstant;
use App\Http\Constant\TokenConstant;
use App\Http\Resources\PlantResource;
use Illuminate\Support\Facades\Http;

class PlantService
{
    private $api_url;
    private $token;

    public function __construct(TokenConstant $token)
    {
        $this->token   = $token;
        $this->api_url = ApiConstant::BASE_URL;
    }

    public function get_all_plant()
    {
        try {
            $token    = $this->token->GetToken();
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$token}",
            ])->get("{$this->api_url}/plant");

            $result = $response->json();
            if ($response->failed()) {
                // throw new \Exception($result['message']);
                return collect();
            }
            $collection = collect($result['data'])->map(function ($item) {
                return (object) $item;
            });
            return PlantResource::collection($collection);
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }

    public function create_plant(array $data)
    {
        try {
            $token    = $this->token->GetToken();
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$token}",
            ])->post("{$this->api_url}/plant/create", $data);

            $result = $response->json();

            if ($response->failed()) {
                throw new \Exception($result['message']);
            }

            return $result;
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }

    public function update_plant(array $data, int $id)
    {
        try {
            $token    = $this->token->GetToken();
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$token}",
            ])->put("{$this->api_url}/plant/$id/edit", $data);

            $result = $response->json();
            if ($response->failed()) {
                throw new \Exception($result['message']);
            }

            return $result;
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }

    public function delete_plant(int $id)
    {
        try {
            $token    = $this->token->GetToken();
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$token}",
            ])->delete("{$this->api_url}/plant/$id/delete");

            $result = $response->json();
            if ($response->failed()) {
                throw new \Exception($result['message']);
            }

            return $result;
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }
}
