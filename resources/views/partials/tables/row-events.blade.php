<tr>
  {{-- <td class="hightlighted {{ $event->VisuallyHighlight() }}"></td> --}}

  {{-- EVENT DATE --}}
  <td colspan="1" width="70" class="text-center td-event-date @if($event->isInProgress()) td-event-in-progress @endif">
    <span class="td-event-day">{{ $event->getEventDate('d') }}</span>
    <br>
    <span class="td-event-month">{{ $event->getEventDate('M') }}</span>
  </td>

  {{-- EVENT LOCATION --}}
  <td colspan="1" class="cell-name">
    <a href="/party/view/{{ $event->idevents }}" class="d-none d-md-block font-weight-bold">
      {{ $event->getEventName() }}
    </a>
    {{ $event->getEventDate('D j M Y') }}, {{ $event->getEventStartEnd() }}
  </td>

  {{-- ICON --}}
  <td class="table-cell-icon text-center" colspan="1">
    @php $event_group = $event->theGroup; @endphp
    @php $group_image = $event_group->groupImage; @endphp
    @if( is_object($group_image) && is_object($group_image->image) )
      <img class="mx-auto" src="{{ $group_image->image->asset_path }}" alt="{{{ $event_group->name }}}">
    @else
      <img class="mx-auto" src="{{ asset('/images/placeholder-avatar.png') }}" alt="{{{ $event_group->name }}}">
    @endif
  </td>

  {{-- GROUP NAME --}}
  <td colspan="1" class="d-none d-md-table-cell">
    <a href="/group/view/{{{ $event->theGroup->idgroups }}}" title="edit group">
      {{{ $event->theGroup->name }}}
    </a>
  </td>

  {{-- INVITES --}}
  <td colspan="1" class="text-center d-none d-md-table-cell">
    {{ $event->all_invited_count }}
  </td>

  {{-- PARTCIPANTS --}}
  <td colspan="1" class="text-center d-none d-md-table-cell">
    {{ $event->pax }}
  </td>

  {{-- EVENT BUTTON/ACTION --}}
  @if( $event->requiresModerationByAdmin() )

    @if( FixometerHelper::hasRole(Auth::user(), 'Administrator') )
      <td class="text-right">Event requires <a href="/party/edit/{{ $event->idevents }}">moderation</a> by an admin</td>
    @else
      <td class="text-right">@lang('partials.event_requires_moderation_by_an_admin')</td>
    @endif

  @elseif ( $event->isUpcoming() && ! $event->isStartingSoon() )

    @if ( $event->isVolunteer() )
      <td class="text-right">
        <span class="font-weight-bold mr-2 d-none d-md-inline">You're going!</span>
        @if ( Auth::check() )
          @php( $user = auth()->user() )
          @php( $copy_link = url("/calendar/single-event/{$event->idevents}") )
          @php( $user_edit_link = url("/profile/edit/{$user->id}") )
          @include('partials.calendar-feed-button', [
            'copy_link' => $copy_link,
            'user_edit_link' => $user_edit_link,
            'modal_title' => __('calendars.events_modal_title'),
            'modal_text' => __('calendars.events_modal_text'),
            'single_event' => true,
          ])
        @endif
      </td>
    @else
      <td class="text-right">
        <a href="/party/join/{{ $event->idevents }}" class="btn btn-primary btn-sm">
          RSVP
        </a>
      </td>
    @endif

  @elseif( $event->isStartingSoon() )

    @if ( $event->isVolunteer() )
      <td colspan="1" class="text-right">
        <span class="font-weight-bold mr-2 d-none d-md-inline">You're going!</span>
        @if ( Auth::check() )
          @php( $user = auth()->user() )
          @php( $copy_link = url("/calendar/single-event/{$event->idevents}") )
          @php( $user_edit_link = url("/profile/edit/{$user->id}") )
          @include('partials.calendar-feed-button', [
            'copy_link' => $copy_link,
            'user_edit_link' => $user_edit_link,
            'modal_title' => __('calendars.events_modal_title'),
            'modal_text' => __('calendars.events_modal_text'),
            'single_event' => true,
          ])
        @endif
      </td>
    @else
      <td colspan="1" class="text-right">
        <a href="/party/join/{{ $event->idevents }}" class="btn btn-primary btn-sm">
          RSVP
        </a>
      </td>
    @endif

  @elseif( $event->isInProgress() )

    @if ( $event->isVolunteer() )
      <td colspan="1" class="text-right">
        <a href="/party/view/{{ $event->idevents }}" class="btn btn-primary btn-sm">
          Add a device
        </a>
      </td>
    @else
      <td colspan="1" class="text-right">
        <a href="/party/join/{{ $event->idevents }}" class="btn btn-primary btn-sm">
          RSVP
        </a>
      </td>
    @endif

  @elseif( $event->hasFinished() )
    <td colspan="1" class="text-right">
      {{-- TODO: What button needs to be displayed here? --}}
      @if ( $event->checkForMissingData()['devices_count'] != 0  )
        @php( $stats = $event->getEventStats($EmissionRatio) )
          {{ $stats['fixed_devices'] }} fixed devices
      @else
          No devices added <a href="/party/view/{{ $event->idevents }}">Add a device</a>
      @endif
    </td>

  @endif
</tr>
