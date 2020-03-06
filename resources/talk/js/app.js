$(document).ready(function() {
    // bind change event to select
  $('.messages-nav-251').on('change', function () {
      const url = $(this).val(); // get selected value
      if (url) { // require a URL
          window.location = document.location.origin + url; // redirect
      }
      return false;
  });
});
