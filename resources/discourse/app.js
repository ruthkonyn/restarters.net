require('../assets/js/bootstrap');

// API call to current site - check for notifications
function ajaxSearchNotifications() {
  $.ajax({
    headers: {
      'X-CSRF-TOKEN': $("input[name='_token']").val()
    },
    type: 'get',
    url: '/api/notifications/discourse/'+ user.username +'/' + user.id,
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

  if (user != 'undefined') {
    ajaxSearchNotifications();
  }
});
