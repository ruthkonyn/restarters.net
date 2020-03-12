// API call to current site - check for user authenticated
function checkAuth() {
  $url = 'https://test-restarters.rstrt.org' + '/test/check-auth';

  $notifications_list_item = $('.notifications-list-item').hide();
  $auth_menu_items = $('.auth-menu-items').hide();
  $auth_menu_items.removeClass('dropdown-menu-items');

  $.ajax({
    headers: {
      // 'X-CSRF-TOKEN': $("input[name='_token']").val(),
      'Content-Type': 'application/x-www-form-urlencoded'
    },
    xhrFields: {
      withCredentials: true
    },
    type: 'GET',
    url: $url,
    datatype: 'json',
    success: function(response) {
      $auth_list_item = $('.auth-list-item');

      if (response.authenticated !== null && response.authenticated !== undefined) {
        if ($notifications_list_item.length) {
          $notifications_list_item.css('display','');
        }

        if ($auth_list_item.length) {
          $auth_menu_items.addClass('dropdown-menu-items');
          $auth_menu_items.css('display','');
        }

        if ($('.my-profile-url').length) {
          $('.my-profile-url').attr('href', response.edit_profile_link);
        }

      } else {
        $auth_list_item.find('a').attr('href', 'https://test-restarters.rstrt.org');
      }
    },
  });
}
