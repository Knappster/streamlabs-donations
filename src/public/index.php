<?php
session_start();

require_once(__DIR__ . '/../../vendor/autoload.php');

use GuzzleHttp\Client;

Dotenv\Dotenv::createImmutable(__DIR__ . '/../../')->load();

$client_id = $_ENV['CLIENT_ID'];
$client_secret = $_ENV['CLIENT_SECRET'];
$redirect_uri = $_ENV['REDIRECT_URI'];
$scopes = [
    'donations.read'
];

if (!isset($_GET['code'])) {
    $url = 'https://streamlabs.com/api/v2.0/authorize';
    $params = http_build_query([
        'response_type' => 'code',
        'client_id' => $client_id,
        'redirect_uri' => $redirect_uri,
        'scope' => implode(' ', $scopes)
    ]);

    header('Location: ' . $url . '?' . $params, true, 302);
    exit();
} else {
    $client = new Client();

    $response = $client->request(
        'POST',
        'https://streamlabs.com/api/v2.0/token',
        [
            'headers' => [
                'accept' => 'application/json',
            ],
            'form_params' => [
                'grant_type' => 'authorization_code',
                'client_id' => $client_id,
                'client_secret' => $client_secret,
                'redirect_uri' => $redirect_uri,
                'code' => $_GET['code']
            ]
        ]
    );

    $auth_tokens = json_decode($response->getBody(), true);
    $_SESSION['auth_tokens'] = $auth_tokens;
    header('Location: /home', true, 302);
    exit();
}
