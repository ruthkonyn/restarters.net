// API call to current site - check for notifications
function ajaxSearchNotifications() {
  // $base_url = window.location.host;

  $url = 'https://test-restarters.rstrt.org' + '/test/discourse/notifications';

  $.ajax({
    headers: {
      // 'X-CSRF-TOKEN': $("input[name='_token']").val(),
      'Content-Type': 'application/x-www-form-urlencoded'
    },
    type: 'GET',
    url: $url,
    datatype: 'json',
    success: function(response) {
      console.log('Success: connected to Discourse.');

      // Response failed
      if (response.message == 'failed') {
        console.log('Success: failed to find any new notifications.');
        return false;
      }

      // If notifications exist then we can create a cookie
      var $notifications = response.notifications;

      if ($notifications.length > 0) {
        console.log('Success: notifications found on Discourse.');

        $('.notification-menu-items').removeClass('d-none');
        $('.toggle-notifications-menu .bell-icon-active').removeClass('d-none');

        $.each($notifications, function(index, $notification) {
          $('.notification-menu-items').append(
            $('<li>').append(
              $('<a>').attr('href','/notifications/' + $notification.id).text($notification.data.title)
            ).attr('class', 'notifcation-text')
          );
        });
      }
    },
  });
}

ajaxSearchNotifications();
