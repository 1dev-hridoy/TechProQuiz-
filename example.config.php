<?php
define('QUIZ_API_KEY', 'YOUR_API_KEY_HERE');
define('USER_LOGIN', 'hridoy09bg');
date_default_timezone_set('UTC');

function setCommonCurlOptions($ch) {
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => 0,
        CURLOPT_TIMEOUT => 30
    ]);
    return $ch;
}