function ajaxSearchNotifications() {

  var html = '<a href="#" class="toggle-notifications-menu">' +
  '<svg class="notification-bell"><span class="bell-icon-active" style="display: none;"></svg></a></span>';
  $('.notification-icon').append(html);

  $.ajax({
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded'
    },
    xhrFields: {
      withCredentials: true
    },
    type: 'GET',
    url: 'https://test-restarters.rstrt.org' + '/test/discourse/notifications',
    datatype: 'json',
    success: function(response) {

      if (response.message == 'failed') {
        return false;
      }

      // If notifications exist then we can create a cookie
      var $notifications = response.notifications;

      if (Object.keys($notifications).length > 0) {
        // console.log('Success: notifications found on Discourse.');

        $('.toggle-notifications-menu .bell-icon-active').show();
        $notification_menu_items = $('.notification-menu-items');
        $notification_menu_items.empty();

        $.each($notifications, function(index, $notification) {
          $notification_menu_items.append(
            $('<li>').append(
              $('<a>').attr('href', 'https://test-restarters.rstrt.org/notifications/' + $notification.id).attr('class', 'notification-link').text($notification.data.title)
            ).attr('class', 'notifcation-text')
          );
        });
      }
    },
  });
}

function goToNotification() {
  $(".notification-link").click(function(){
    document.location.href= $(this).attr('href');
  });
}
