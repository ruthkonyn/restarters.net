<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class notificationController extends Controller
{
  public function __invoke()
  {
      dd(true);

      // {
      //   "notifications": [
      //     {
      //       "id": 0,
      //       "notification_type": 0,
      //       "read": true,
      //       "created_at": "string",
      //       "post_number": 0,
      //       "topic_id": 0,
      //       "fancy_title": "string",
      //       "slug": "string",
      //       "data": {
      //         "topic_title": "string",
      //         "original_post_id": 0,
      //         "original_post_type": 0,
      //         "original_username": "string",
      //         "revision_number": {},
      //         "display_username": "string"
      //       }
      //     }
      //   ],
      //   "total_rows_notifications": 0,
      //   "seen_notification_id": 0,
      //   "load_more_notifications": "string"
      // }
  }
}
