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

function toggleNotifications() {
  $('.notification-icon').click(function(e) {
    e.preventDefault();
console.log('clicked');
    // If item is already active then close all.
    if ( $(this).hasClass('dropdown-active')) {
      $('.notification-icon').each(function() {
        $(this).removeClass('dropdown-active');
        $(this).parents().children('.dropdown-menu-items').hide();
      });

      return false;
    }

    // Show items.
    $('.toggle-notifications-menu').toggleClass('dropdown-active');
    $('.toggle-notifications-menu').parents().children('.dropdown-menu-items').toggle();
  });
}


setTimeout(function() {
  toggleNotifications();
  ajaxSearchNotifications();
}, 300);
