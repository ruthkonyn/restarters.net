$(document).ready(function() {

  require('./components/dropdown.js');
  require('./components/table.js');

  console.log('ready!');

  // Change controller for collapse text
  $('.collapse-plus-and-minus-controller').click(function() {
    $(this).text(function(i,old){
      return old == $(this).attr('data-close-text') ? $(this).attr('data-open-text') : $(this).attr('data-close-text');
    });
  });

  // Initialize tooltips
  $(function () {
    $('[data-toggle="tooltip"]').tooltip();
  });

  $('#tesing123').tooltip('show');

  // $("form[id*='-search']").
});

// Change tab view onload where hash is within URL
window.onload = function() {
  var hash = window.location.hash;
  if(hash != '' || hash != undefined) {
    var $element = $('a[href="' + hash + '"]');
    if ($element.length == 1) {
      $element.tab('show');
    }
  }
}
