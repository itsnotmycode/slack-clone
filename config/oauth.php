<?php

return [
    'google_client_id' => env('GOOGLE_CLIENT_ID',''),
    'google_client_secret' => env('GOOGLE_CLIENT_SECRET', ''),
    'google_url' => env('GOOGLE_URL', ''),
    'google_redirect' => env('GOOGLE_REDIRECT', 'http://127.0.0.1:8000/callback/google'),

    'facebook_client_id' => env('FACEBOOK_CLIENT_ID', ''),
    'facebook_client_secret' => env('FACEBOOK_CLIENT_SECRET', ''),
    'facebook_url' => env('FACEBOOK_URL', ''),
    'facebook_redirect' => env('FACEBOOK_REDIRECT', 'https://lara.test/callback/facebook'),

    'wp_client_id' => env('WP_CLIENT_ID', ''),
    'wp_client_secret' => env('WP_CLIENT_SECRET', ''),
    'wp_url' => env('WP_URL', ''),
    'wp_redirect' => env('WP_REDIRECT', 'http://127.0.0.1:8000/callback/wp'),
];
