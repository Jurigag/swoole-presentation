<?php

function request($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_NOBODY, TRUE); // remove body
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Host' => "www.google.com",
        "User-Agent" => 'Chrome/49.0.2587.3',
        'Accept' => 'text/html,application/xhtml+xml,application/xml',
        'Accept-Encoding' => 'gzip',
    ]);
    $head = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    return [$url => $httpCode];
}

$result = [];
$code = request('www.google.com');
$result[] = $code;
$code = request('www.bing.com');
$result[] = $code;
$code = request('www.indahash.com');
$result[] = $code;
$code = request('www.wykop.pl');
$result[] = $code;
$code = request('www.facebook.com');
$result[] = $code;
$code = request('www.onet.pl');
$result[] = $code;
var_dump($result);
