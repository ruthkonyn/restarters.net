require('../assets/js/bootstrap');

function createCookie(name,value,minutes) {
  if (minutes) {
    var date = new Date();
    date.setTime(date.getTime()+(minutes*60*1000));
    var expires = "; expires="+date.toGMTString();
  } else {
    var expires = "";
  }

  document.cookie = name+"="+value+expires+"; path=/";
}

function getCookie(name) {
  var dc = document.cookie;
  var prefix = name + "=";
  var begin = dc.indexOf("; " + prefix);
  if (begin == -1) {
    begin = dc.indexOf(prefix);
    if (begin != 0) return null;
  } else {
    begin += 2;
    var end = document.cookie.indexOf(";", begin);
    if (end == -1) {
      end = dc.length;
    }
  }
  // because unescape has been deprecated, replaced with decodeURI
  //return unescape(dc.substring(begin + prefix.length, end));
  return decodeURI(dc.substring(begin + prefix.length, end));
}

function ajaxSearchNotifications() {
  $.ajax({
    headers: {
      'X-CSRF-TOKEN': $("input[name='_token']").val()
    },
    type: 'get',
    url: '/api/notifications/discourse/james/' + user_id,
    datatype: 'json',
    success: function(data) {
      var $items = JSON.parse(data);

      if ($items.length > 0) {
        createCookie('has_notifications', true, 10);
      }
    },
  });
}

// A $( document ).ready() block.
$( document ).ready(function() {
  console.log( "ready!" );

  if (! getCookie('has_notifications')) {
    ajaxSearchNotifications();
  }
});
