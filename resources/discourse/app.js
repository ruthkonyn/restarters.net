require('../assets/js/bootstrap');

// API call to current site - check for notifications
function ajaxSearchNotifications() {
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
      console.log('Successfully connected to discourse');

      if (response.message == 'cookies_set') {
        console.log('Notifications cookie is already set');

        return false;
      }

      // Response failed
      if (response.message == 'failed') {
        return false;
      }

      // If notifications exist then we can create a cookie
      var $notifications = JSON.parse(response.notifications);

      if ($notifications.length > 0) {
        console.log('Notifications found on discourse');
      }
    },
  });
}



$( document ).ready(function() {
  console.log( "ready!" );

  ajaxSearchNotifications();
});
