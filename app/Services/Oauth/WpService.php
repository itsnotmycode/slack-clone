<?php


namespace App\Services\Oauth;


use App\Contracts\Service;
use GuzzleHttp\Client;

class WpService implements Service
{
    /**
     * @return string
     */
    public static function generateOauthUri()
    {
        $state = md5(mt_rand());
        $query = http_build_query([
            'client_id'  => config('oauth.wp_client_id'),
            'redirect_uri' => config('oauth.wp_redirect'),
            'response_type' => 'code',
            'scope' => 'auth',
            'state' => $state,
        ]);

        return config('oauth.wp_url').'?'.$query;
    }

    /**
     * @param $code
     * @return \Psr\Http\Message\ResponseInterface
     */
    public static function authorizeClient($code)
    {
        $http = new Client();
        $response = $http->post('https://public-api.wordpress.com/oauth2/token', [
            'form_params' => [
                'grant_type' => 'authorization_code',
                'client_id' => config('oauth.wp_client_id'),
                'client_secret' => config('oauth.wp_client_secret'),
                'redirect_uri' => config('oauth.wp_redirect'),
                'code' => $code,
            ]
        ]);

        $response = json_decode($response->getBody());

        return $response->access_token;
    }

    /**
     * @param $token
     * @return \Psr\Http\Message\ResponseInterface
     */
    public static function getUser($token)
    {
        $http = new Client();

        $response = $http->get('https://public-api.wordpress.com/rest/v1/me/', [
            'headers' => [
                'Authorization' => "Bearer {$token}"
            ]
        ]);

        $response = json_decode($response->getBody());

        return $response;
    }
}
