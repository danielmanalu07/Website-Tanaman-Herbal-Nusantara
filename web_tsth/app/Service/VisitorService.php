<?php
namespace App\Service;

use App\Http\Constant\ApiConstant;
use App\Http\Constant\TokenConstant;
use App\Http\Resources\VisitorResource;
use Illuminate\Support\Facades\Http;

class VisitorService
{
    private $api_url;
    private $token;

    public function __construct(TokenConstant $token)
    {
        $this->api_url = ApiConstant::BASE_URL;
        $this->token   = $token;
    }

    public function get_all_visitor()
    {
        try {
            $token    = $this->token->GetToken();
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$token}",
            ])->get("{$this->api_url}/visitors");

            $result = $response->json();
            if ($response->failed()) {
                return collect();
            }
            $collection = collect($result['data'])->map(function ($item) {
                return (object) $item;
            });

            return VisitorResource::collection($collection);
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }

    public function create_visitor(array $data)
    {
        try {
            $token    = $this->token->GetToken();
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$token}",
            ])->post("{$this->api_url}/visitors/create", $data);

            $result = $response->json();
            if ($response->failed()) {
                throw new \Exception($result['message']);
            }

            return new VisitorResource($result);
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }

    public function update_visitor(array $data, int $id)
    {
        try {
            $token    = $this->token->GetToken();
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$token}",
            ])->put("{$this->api_url}/visitors/$id/update", $data);

            $result = $response->json();

            if ($response->failed()) {
                throw new \Exception($result['message']);
            }

            return new VisitorResource($result);
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }

    public function delete_visitor(int $id)
    {
        try {
            $token    = $this->token->GetToken();
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$token}",
            ])->delete("{$this->api_url}/visitors/$id/delete");

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
