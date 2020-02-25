// API call to current site - check for notifications
function ajaxSearchNotifications() {
  // $base_url = window.location.host;

  $url = '/notifications/discourse/';

  if (user != 'undefined') {
    $url = $url + user.username + '/' + user.id;
  }

  $.ajax({
    headers: {
      'X-CSRF-TOKEN': $("input[name='_token']").val()
    },
    type: 'GET',
    url: $url,
    datatype: 'json',
    success: function(response) {
      console.log('Success: connected to Discourse.');

      if (response.message == 'cookies_set') {
        console.log('Success: notification cookie is currently set.');

        return false;
      }

      // Response failed
      if (response.message == 'failed') {
        console.log('Success: failed to find any new notifications.');
        return false;
      }

      // If notifications exist then we can create a cookie
      var $notifications = JSON.parse(response.notifications);

      if ($notifications.length > 0) {
        console.log('Success: notifications found on Discourse.');
      }
    },
  });
}

ajaxSearchNotifications();
