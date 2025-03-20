<?php
namespace App\Service;

use App\Http\Constant\ApiConstant;
use App\Http\Constant\TokenConstant;
use App\Http\Resources\UserProfileResource;
use Illuminate\Support\Facades\Http;

class AuthService
{
    private $api_url;
    private $token;

    public function __construct(TokenConstant $token)
    {
        $this->api_url = ApiConstant::BASE_URL;
        $this->token   = $token;

    }
    public function login($username, $password)
    {
        $response = Http::post("{$this->api_url}/login", [
            'username' => $username,
            'password' => $password,
        ]);

        $data = $response->json();
        if ($response->failed()) {
            return redirect()->back()->with('error', $data['message']);
        }
        $this->token->SetToken($data['token']);
        if ($data['user']['username'] !== 'admin') {
            return redirect()->back()->with('error', 'Only admin can access this page.');
        }

        return $data;
    }
    public function dashboard()
    {
        $token    = $this->token->GetToken();
        $response = Http::withHeaders([
            'Authorization' => "Bearer {$token}",
        ])->get("{$this->api_url}/profile");

        $res = $response->json();

        $data = new UserProfileResource((object) $res['data']);
        return $data;
    }

    public function logout()
    {
        $token = $this->token->GetToken();
        if (! $token) {
            return redirect()->route('admin.login')->with('error', 'Unauthorized');
        }

        $response = Http::withHeaders([
            'Authorization' => "Bearer {$token}",
        ])->post("{$this->api_url}/logout");

        $data = $response->json();
        if ($response->failed()) {
            return redirect()->route('admin.login')->with('error', $data['message']);
        }

        TokenConstant::RemoveToken();
        return $data;
    }
}
