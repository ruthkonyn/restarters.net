<?php

Route::get('/discourse/{username}/{user_id}', 'NotificationController');



// $curl = curl_init(env('DISCOURSE_URL').'/admin/users/list/active.json');
//
// curl_setopt($curl, CURLOPT_HTTPHEADER, array(
//   "Content-Type: application/json",
//   "Api-Key: ".env('DISCOURSE_APIKEY'),
//   "Api-Username: ".env('DISCOURSE_APIUSER')
// ));
//
// $resp = curl_exec($curl);
//
// dd($resp);
