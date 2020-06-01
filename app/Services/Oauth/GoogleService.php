<?php


namespace App\Services\Oauth;


use App\Contracts\Service;
use GuzzleHttp\Client;

class GoogleService implements Service
{
    /**
     * @param $code
     * @return \Psr\Http\Message\ResponseInterface
     */
    public static function authorizeClient($code)
    {
        $http = new Client();

        $response = $http->post('https://oauth2.googleapis.com/token', [
            'form_params' => [
                'grant_type' => 'authorization_code',
                'client_id' => config('oauth.google_client_id'),
                'client_secret' => config('oauth.google_client_secret'),
                'redirect_uri' => config('oauth.google_redirect'),
                'code' => $code,
            ]
        ]);

        $response = json_decode($response->getBody());

        return $response->access_token;
    }

    /**
     * @return string
     */
    public static function generateOauthUri()
    {
        $query = http_build_query([
            'client_id'  => config('oauth.google_client_id'),
            'redirect_uri' => config('oauth.google_redirect'),
            'response_type' => 'code',
            'scope' => 'openid profile email',
            'access_type' => 'offline'
        ]);

        return config('oauth.google_url').'?'.$query;
    }

    /**
     * @param $token
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    public static function getUser($token)
    {
        $http = new Client();

        $response = $http->request('GET', 'https://www.googleapis.com/oauth2/v3/userinfo', [
            'headers' => [
                'Authorization' => "Bearer ${token}"
            ]
        ]);

        $response = json_decode($response->getBody());
        return $response;
    }
}
