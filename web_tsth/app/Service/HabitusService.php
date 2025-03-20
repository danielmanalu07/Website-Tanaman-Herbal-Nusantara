<?php
namespace App\Service;

use App\Http\Constant\ApiConstant;
use App\Http\Constant\TokenConstant;
use App\Http\Resources\HabitusResource;
use Illuminate\Support\Facades\Http;

class HabitusService
{
    private $api_url;
    private $token;

    public function __construct(TokenConstant $token)
    {
        $this->api_url = ApiConstant::BASE_URL;
        $this->token   = $token;
    }

    public function get_all()
    {
        $token    = $this->token->GetToken();
        $response = Http::withHeaders([
            'Authorization' => "Bearer {$token}",
        ])->get("{$this->api_url}/habitus");

        $result = $response->json();

        if ($response->successful() && isset($result['success']) && $result['success'] === true) {
            $collection = collect($result['data'])->map(function ($item) {
                return (object) $item;
            });
            return HabitusResource::collection($collection);
        }
        return collect();
    }

    public function create_habitus($name)
    {
        $token    = $this->token->GetToken();
        $response = Http::withHeaders([
            'Authorization' => "Bearer {$token}",
        ])->post("{$this->api_url}/habitus/create", [
            'name' => $name,
        ]);

        $result = $response->json();
        if ($response->failed()) {
            return $result;
        }

        return $result;
    }

    public function update_habitus(string $name, int $id)
    {
        $token    = $this->token->GetToken();
        $response = Http::withHeaders([
            'Authorization' => "Bearer {$token}",
        ])->put("{$this->api_url}/habitus/$id/update", [
            'name' => $name,
        ]);

        $result = $response->json();
        if ($response->failed()) {
            return $result;
        }

        return new HabitusResource($result);
    }

    public function delete_habitus(int $id)
    {
        $token    = $this->token->GetToken();
        $response = Http::withHeaders([
            'Authorization' => "Bearer {$token}",
        ])->delete("{$this->api_url}/habitus/$id/delete");

        $result = $response->json();
        if ($response->failed()) {
            return $result;
        }

        return $result;
    }

    // public function get_detail(int $id)
    // {
    //     $token    = $this->token->GetToken();
    //     $response = Http::withHeaders([
    //         'Authorization' => "Bearer {$token}",
    //     ])->post("{$this->api_url}/habitus/$id");

    //     $result = $response->json();
    //     if ($response->failed()) {
    //         return redirect()->back()->with('error', $result['message']);
    //     }

    //     return $result;
    // }
}
