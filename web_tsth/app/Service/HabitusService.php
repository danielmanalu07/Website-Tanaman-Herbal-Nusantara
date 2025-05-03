<?php
namespace App\Service;

use App\Http\Constant\ApiConstant;
use App\Http\Constant\LanguageConstant;
use App\Http\Constant\TokenConstant;
use App\Http\Resources\HabitusResource;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;

class HabitusService
{
    private $api_url;
    private $token, $language;

    public function __construct(TokenConstant $token, LanguageConstant $language)
    {
        $this->api_url  = ApiConstant::BASE_URL;
        $this->token    = $token;
        $this->language = $language;
    }

    public function get_all()
    {
        $token    = $this->token->GetToken();
        $lang     = $this->language->GetLanguage();
        $response = Http::withHeaders([
            'Authorization'   => "Bearer {$token}",
            'Accept-Language' => "{$lang}",
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

    public function get_all_user()
    {
        $lang     = $this->language->GetLanguageUser();
        $response = Http::withHeaders([
            'Accept-Language' => "{$lang}",
        ])->get("{$this->api_url}/habitus-user");

        $result = $response->json();

        if ($response->successful() && isset($result['success']) && $result['success'] === true) {
            $collection = collect($result['data'])->map(function ($item) {
                return (object) $item;
            });
            return HabitusResource::collection($collection);
        }
        return collect();
    }

    public function create_habitus(array $data)
    {
        $token   = $this->token->GetToken();
        $request = Http::withHeaders([
            'Authorization' => "Bearer {$token}",
        ]);

        if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
            $request->attach('image', file_get_contents($data['image']->getRealPath()), $data['image']->getClientOriginalName());
        }

        $response = $request->post("{$this->api_url}/habitus/create", $data);

        $result = $response->json();
        if ($response->failed()) {
            return $result;
        }

        return $result;
    }

    public function update_habitus(array $data, int $id)
    {
        $token   = $this->token->GetToken();
        $request = Http::withHeaders([
            'Authorization' => "Bearer {$token}",
        ]);

        $updateData = [
            ['name' => 'name', 'contents' => $data['name']],
            ['name' => '_method', 'contents' => 'PUT'],
        ];

        foreach ($updateData as $item) {
            $request = $request->attach($item['name'], $item['contents']);
        }
        if (request()->hasFile('image')) {
            if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
                $request->attach('image', file_get_contents($data['image']->getRealPath()), $data['image']->getClientOriginalName());
            }
        }

        $response = $request->post("{$this->api_url}/habitus/$id/update", $data);

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
}
