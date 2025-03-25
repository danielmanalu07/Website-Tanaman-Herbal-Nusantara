<?php
namespace App\Service;

use App\Http\Constant\ApiConstant;
use App\Http\Constant\TokenConstant;
use App\Http\Resources\LandResource;
use Illuminate\Support\Facades\Http;

class LandService
{
    private $api_url;
    private $token;

    public function __construct(TokenConstant $token)
    {
        $this->api_url = ApiConstant::BASE_URL;
        $this->token   = $token;
    }

    public function get_all_land()
    {
        try {
            $token    = $this->token->GetToken();
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$token}",
            ])->get("{$this->api_url}/land");

            $result = $response->json();
            if ($response->failed()) {
                return collect();
            }
            $collection = collect($result['data'])->map(function ($item) {
                return (object) $item;
            });
            return LandResource::collection($collection);
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }

    public function create_land(string $name)
    {
        try {
            $token    = $this->token->GetToken();
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$token}",
            ])->post("{$this->api_url}/land/create", [
                'name' => $name,
            ]);

            $result = $response->json();

            if ($response->failed()) {
                throw new \Exception($result['message']);
            }

            return new LandResource($result);

        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }

    public function update_land(string $name, int $id)
    {
        try {
            $token    = $this->token->GetToken();
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$token}",
            ])->put("{$this->api_url}/land/$id/edit", [
                'name' => $name,
            ]);

            $result = $response->json();

            if ($response->failed()) {
                throw new \Exception($result['message']);
            }

            return new LandResource($result);
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }

    public function delete_land(int $id)
    {
        try {
            $token    = $this->token->GetToken();
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$token}",
            ])->delete("{$this->api_url}/land/$id/delete");

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
