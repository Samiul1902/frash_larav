<?php
use Illuminate\Support\Facades\Http;

require __DIR__.'/vendor/autoload.php';

$apiKey = 'AIzaSyBb8ZuG7hbAnI8N75R6aHufEOUM0cUPzL8';
$url = "https://generativelanguage.googleapis.com/v1beta/models?key={$apiKey}";

echo "Checking URL: $url\n";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // For dev env
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "HTTP Code: $httpCode\n";
echo "Response: $response\n";
