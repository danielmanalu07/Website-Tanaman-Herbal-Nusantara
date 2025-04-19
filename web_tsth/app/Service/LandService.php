<?php
namespace App\Service;

use App\Http\Constant\ApiConstant;
use App\Http\Constant\LanguageConstant;
use App\Http\Constant\TokenConstant;
use App\Http\Resources\LandResource;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;

class LandService
{
    private $api_url;
    private $token, $language;

    public function __construct(TokenConstant $token, LanguageConstant $languageConstant)
    {
        $this->api_url  = ApiConstant::BASE_URL;
        $this->token    = $token;
        $this->language = $languageConstant;
    }

    public function get_all_land()
    {
        try {
            $token    = $this->token->GetToken();
            $lang     = $this->language->GetLanguage();
            $response = Http::withHeaders([
                'Authorization'   => "Bearer {$token}",
                'Accept-Language' => "{$lang}",
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

    public function get_all_land_user()
    {
        try {
            $lang     = $this->language->GetLanguage();
            $response = Http::withHeaders([
                'Accept-Language' => "{$lang}",
            ])->get("{$this->api_url}/land-user");

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

    public function create_land(array $data)
    {
        try {
            $token   = $this->token->GetToken();
            $request = Http::withHeaders([
                'Authorization' => "Bearer {$token}",
            ]);

            $multipart = [
                [
                    'name'     => 'name',
                    'contents' => $data['name'],
                ],
            ];

            if (! empty($data['plants'])) {
                foreach ($data['plants'] as $plant) {
                    $multipart[] = [
                        'name'     => 'plants[]', // multiple plants
                        'contents' => $plant,
                    ];
                }
            }

            if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
                $multipart[] = [
                    'name'     => 'image',
                    'contents' => fopen($data['image']->getRealPath(), 'r'),
                    'filename' => $data['image']->getClientOriginalName(),
                ];
            }

            $response = $request->asMultipart()->post("{$this->api_url}/land/create", $multipart);

            $result = $response->json();

            if ($response->failed()) {
                throw new \Exception($result['message'] ?? 'Failed to create land');
            }

            return new LandResource($result);

        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }

    public function update_land(int $id, array $data)
    {
        try {
            $token   = $this->token->GetToken();
            $request = Http::withHeaders([
                'Authorization' => "Bearer {$token}",
            ]);

            $multipart = [
                [
                    'name'     => 'name',
                    'contents' => $data['name'],
                ],
                [
                    'name'     => '_method',
                    'contents' => 'PUT',
                ],
            ];

            if (! empty($data['plants'])) {
                foreach ($data['plants'] as $plant) {
                    $multipart[] = [
                        'name'     => 'plants[]',
                        'contents' => $plant,
                    ];
                }
            }

            if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
                $multipart[] = [
                    'name'     => 'image',
                    'contents' => fopen($data['image']->getRealPath(), 'r'),
                    'filename' => $data['image']->getClientOriginalName(),
                ];
            }

            $response = $request->asMultipart()->post("{$this->api_url}/land/{$id}/edit", $multipart);

            $result = $response->json();

            if ($response->failed()) {
                throw new \Exception($result['message'] ?? 'Failed to update land');
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
