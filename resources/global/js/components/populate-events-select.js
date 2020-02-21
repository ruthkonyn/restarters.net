function searchEventsByGroup() {
  $group_id = $(".change-group :selected").val();

  $.ajax({
    headers: {
      'X-CSRF-TOKEN': $("input[name='_token']").val()
    },
    type: 'GET',
    url: '/api/events/'+ $group_id,
    datatype: 'json',
    success: function(response) {
      $('.change-events option').remove();
      $events = JSON.parse(response.events);

      $.each($events, function($event_id, $event_name) {
        var data = {
            id: $event_id,
            text: $event_name
        };

        var newOption = new Option(data.text, data.id, false, false);
        $('.change-events').append(newOption).trigger('change');
      });

      console.log('Success: Found ' + $('.change-events option').length + ' events.');
    },
  });
}


$(document).on('change', '.change-group', function(){
  searchEventsByGroup();
});

$(document).on('change', '.change-events', function(){
  $('.change-event-url').attr('href', '/party/view/' + $(this).val());
});

searchEventsByGroup();
