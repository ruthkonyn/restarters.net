// Bootstrap js
require('../../assets/js/bootstrap');

$(document).ready(function() {
  require('./components/dropdown.js');
  require('./components/ajax-search-discourse-notifications.js');

  console.log('Global js ready!');

  // Keep hash within URL when toggling between Bootstrap Panes/Tabs
  $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
    window.location.hash = $(this).attr('href');
  });

  $("form[id$='-search']").submit(function (e) {
    if ($('#formHash').length) {
      $('#formHash').val(window.location.hash);
    } else {
      $(this).append(
        $('<input>', {
          type: 'hidden',
          id: 'formHash',
          name: 'formHash',
          val: window.location.hash
        })
      );
    }
  });
});

// Change Bootstrap Pane/Tab view onload where hash is within URL
window.onload = function() {

  var hash = window.location.hash;

  if ( $('#formHash').length ) {
    var hash = $('#formHash').val();
  }

  if(hash != '' || hash != undefined) {
    var $element = $('a[href="' + hash + '"]');
    if ($element.length == 1) {
      $element.tab('show');
    }
  }
}
