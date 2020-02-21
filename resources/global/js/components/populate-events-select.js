function searchEventsByGroup() {
  $current_group = $(".change-group :selected").val();

  $('.change-events option').prop('disabled', true);
  $group_event_options = $('.change-events option[data-group-id="'+ $current_group +'"]');
  $group_event_options.show();
  console.log($group_event_options.length);

  console.log('done');
}

$(document).on('change', '.change-group', function(){
// $(".").on('change', function(){
  searchEventsByGroup();
});

searchEventsByGroup();
