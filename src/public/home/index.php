<?php

require_once(__DIR__ . '/../../../vendor/autoload.php');

use GuzzleHttp\Client;

$tokens_file_path = __DIR__ . '/../../storage/tokens.json';
$tokens = false;

if (is_file($tokens_file_path)) {
    $tokens = json_decode(file_get_contents($tokens_file_path), true);
}

if ($tokens !== false && isset($tokens['access_token'])) {
    $client = new Client();

    // echo '<pre>' . print_r($tokens, true) . '</pre>';

    $response = $client->request(
        'GET',
        'https://streamlabs.com/api/v2.0/donations',
        [
            'headers' => [
                'accept' => 'application/json',
                'Authorization' => 'Bearer ' . $tokens['access_token']
            ]
        ]
    );

    $donations = json_decode($response->getBody(), true);
    $donations_json = json_encode($donations, JSON_PRETTY_PRINT);
    file_put_contents(__DIR__ . '/../../storage/donations.json', $donations_json);
    echo '<h1>Donations</h1>';
    echo '<pre>' . print_r($donations_json, true) . '</pre>';
}
