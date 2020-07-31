<?php

namespace App\Http\Controllers;

use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * AuthController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth:sanctum', ['only' => 'me']);
    }

    /**
     * @param Request $request
     *
     * @return array
     */
    public function me(Request $request)
    {
        $user = $request->user();

        $user->current_match = $user->ongoing()
            ->with('players')
            ->first();

        return compact('user');
    }

    /**
     * @param Request $request
     *
     * @return array
     */
    public function faceit(Request $request)
    {
        $code = $request->get('code');

        $http = new Client();

        $token = (object) json_decode((string) $http->request('POST', 'https://api.faceit.com/auth/v1/oauth/token', [
            'auth' => [config('services.faceit.client_id'), config('services.faceit.secret')],
            'form_params' => [
                'code' => $code,
                'grant_type' => 'authorization_code',
            ]
        ])->getBody());

        $data = (object) json_decode((string) $http->request('GET', 'https://api.faceit.com/auth/v1/resources/userinfo', [
            'headers' => [
                'Authorization' => 'Bearer ' . $token->access_token,
            ]
        ])->getBody());

        /**
         * @var User $user
         */
        $user = User::firstOrNew([
            'uid' => $data->guid,
        ]);

        $user->avatar = $data->picture;
        $user->nickname = $data->nickname;
        $user->save();

        return [
            'token' => $user->createToken('faceit')->plainTextToken,
        ];
    }
}
