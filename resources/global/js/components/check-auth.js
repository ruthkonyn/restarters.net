// API call to current site - check for user authenticated
function checkAuth() {
  $url = 'https://test-restarters.rstrt.org' + '/check-auth';

  $.ajax({
    headers: {
      'X-CSRF-TOKEN': $("input[name='_token']").val(),
      'Content-Type': 'application/x-www-form-urlencoded'
    },
    type: 'GET',
    url: $url,
    datatype: 'json',
    success: function(response) {
      $notifications_list_item = $('.notifications-list-item');
      $auth_list_item = $('.auth-list-item');
      $auth_menu_items = $('.auth-menu-items');

      if (response.authenticated == true) {
        if ($notifications_list_item.length) {
          $notifications_list_item.removeClass('d-none')
        }

        if ($auth_list_item.length) {
          $auth_menu_items.removeClass('d-none')
        }
      } else {
        $auth_list_item.find('a').attr('href', window.location.origin + '/');
      }
    },
  });
}

checkAuth();
