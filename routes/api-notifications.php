<?php

Route::get('/discourse', 'NotificationController');

$client = new \GuzzleHttp\Client();

$url = env('DISCOURSE_URL').'/notifications.json';

$response = $client->request( 'GET', $url, [
    'headers' => [
      'Api-Key' => env('DISCOURSE_APIKEY'),
      'Api-Username' => env('DISCOURSE_APIUSER')
    ]
  ]
);

$array = json_decode($response->getBody()->getContents(), true);
$collection = collect($array['notifications']);
dd($collection->first());










$curl = curl_init(env('DISCOURSE_URL').'/admin/users/list/active.json');

curl_setopt($curl, CURLOPT_HTTPHEADER, array(
  "Content-Type: application/json",
  "Api-Key: ".env('DISCOURSE_APIKEY'),
  "Api-Username: ".env('DISCOURSE_APIUSER')
));

$resp = curl_exec($curl);

dd($resp);

dd();

// DISCOURSE_APIKEY
// DISCOURSE_APIUSER
// DISCOURSE_SECRET
