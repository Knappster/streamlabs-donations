<?php
session_start();

require_once(__DIR__ . '/../../../vendor/autoload.php');

use GuzzleHttp\Client;

$tokens = false;

if (isset($_SESSION['auth_tokens'])) {
    $client = new Client();

    $response = $client->request(
        'GET',
        'https://streamlabs.com/api/v2.0/donations',
        [
            'headers' => [
                'accept' => 'application/json',
                'Authorization' => 'Bearer ' . $_SESSION['auth_tokens']['access_token']
            ]
        ]
    );

    $donations = json_decode($response->getBody(), true);
    $donations_json = json_encode($donations, JSON_PRETTY_PRINT);
    header('Content-Type: application/json; charset=utf-8');
    echo $donations_json;
}
