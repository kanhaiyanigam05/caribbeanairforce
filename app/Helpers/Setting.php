<?php

namespace App\Helpers;

class Setting
{
    public static function data()
    {
        return (object) [
            'site_name' => 'Caribbean Airforce',
            'site_url' => 'https://caribbeanairforce.com/',
            'logo' => 'asset\images\logo-25.png',
            'favicon' => 'asset\images\fav-32.jpg',
            'phone' => '404-579-1211',
            'email' => 'info@caribbeanairforce.com',
            'facebook' => 'https://www.facebook.com/',
            'twitter' => 'https://www.twitter.com/',
            'linkedin' => 'https://www.linkedin.com/',
            'instagram' => 'https://www.instagram.com/',
            'youtube' => 'https://www.youtube.com/',
        ];
    }
    public static function maskEmail($email)
    {
        if (!strpos($email, '@')) {
            return $email;
        }
        [$local, $domain] = explode('@', $email);
        $maskedLocal = substr($local, 0, 2);
        $maskedLocal .= str_repeat('.', max(0, strlen($local) - 2));
        return "{$maskedLocal} @ {$domain}";
    }
    public static function formatFollowers($count)
    {
        if ($count >= 1000) {
            return number_format($count / 1000, 1) . 'k';
        }
        return $count;
    }
}
