<?php


namespace App\Contracts;


interface Service
{
    public static function authorizeClient($request);

    public static function generateOauthUri();

    public static function getUser($token);
}
