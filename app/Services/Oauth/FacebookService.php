<?php


namespace App\Services\Oauth;


use App\Contracts\Service;
use GuzzleHttp\Client;

class FacebookService implements Service
{
    /**
     * @return string
     */
    public static function generateOauthUri()
    {
        $query = http_build_query([
            'client_id'  => config('oauth.facebook_client_id'),
            'redirect_uri' => config('oauth.facebook_redirect'),
            'scope' => 'email',
        ]);

        return config('oauth.facebook_url').'?'.$query;
    }

    /**
     * @param $code
     * @return \Psr\Http\Message\ResponseInterface
     */
    public static function authorizeClient($code)
    {
        $http = new Client();

        $response = $http->get('https://graph.facebook.com/v6.0/oauth/access_token', [
            'query' => [
                'client_id' => config('oauth.facebook_client_id'),
                'client_secret' => config('oauth.facebook_client_secret'),
                'redirect_uri' => config('oauth.facebook_redirect'),
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

        $response = $http->get('https://graph.facebook.com/v6.0/me?access_token=' . $token . '&fields=id,name,email');

        $response = json_decode($response->getBody());
        return $response;
    }
}
