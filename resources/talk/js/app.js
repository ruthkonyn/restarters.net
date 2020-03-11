function navigateUrl(item) {
  if(item.value) {
    location.href = document.location.origin + item.value;
  }
}

setTimeout(function() {
  var options = document.querySelectorAll(".messages-dropdown-123 option");
  for(const option of options) {
    const url = option.dataset.url;
    const location = window.location.href;
    const lastPart = location.substr(location.lastIndexOf('/') + 1);
    if (lastPart == url) {
      option.setAttribute("selected", "");
      break;
    }
  }
}, 1000);

setTimeout(function() {
  if (window.location.href.indexOf("messages") > -1) {
    var inbox_tab = document.querySelector('.inbox');
    inbox_tab.classList.add('active');
  } else {
    var forum_tab = document.querySelector('.forum');
    forum_tab.classList.add('active');
  }
}, 300);

function addActive(tab) {
  var alreadyActive = document.querySelector('.active');
  alreadyActive.classList.remove('active');
  tab.classList.add('active');
}

(function() {
  $('.toggle-notifications-menu').click(function(e) {
    e.preventDefault();
    // If item is already active then close all.
    if ( $(this).hasClass('dropdown-active')) {
      $('.toggle-dropdown-menu').each(function() {
        $(this).removeClass('dropdown-active');
        $(this).parents().children('.dropdown-menu-items').hide();
      });

      return false;
    }

    // Close all existing items except current.
    $('.toggle-dropdown-menu').not(this).each(function() {
      $(this).removeClass('dropdown-active');
      $(this).parents().children('.dropdown-menu-items').hide();
    });

    // Show items.
    $(this).toggleClass('dropdown-active');
    $(this).parents().children('.dropdown-menu-items').toggle();
  });
});

setTimeout(function() {
  ajaxSearchNotifications();
}, 300);
