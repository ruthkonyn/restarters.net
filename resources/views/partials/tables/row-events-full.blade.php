<tr>
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

  {{-- GROUP ICON --}}
  <td colspan="1" class="table-cell-icon">
    @php( $group_image = $event->theGroup->groupImage )
    @if( is_object($group_image) && is_object($group_image->image) )
      <img src="{{ asset('/uploads/thumbnail_' . $group_image->image->path) }}" alt="{{{ $event->theGroup->name }}}">
    @else
      <img src="{{ asset('/images/placeholder-avatar.png') }}" alt="{{{ $event->theGroup->name }}}">
    @endif
  </td>

  {{-- PARTICPANTS --}}
  <td colspan="1">
    {{ $event->pax }}
  </td>

  {{-- RESTARTERS --}}
  <td colspan="1">
    {{ $event->pax }}
  </td>

  {{-- WASTE PREVENTED --}}
  <td colspan="1">

  </td>

  {{-- CO2 EMISSIONS PREVENTED --}}
  <td colspan="1">

  </td>

  {{-- FIXED DEVICES --}}
  <td colspan="1">

  </td>

  {{-- REPAIRABLE DEVICES --}}
  <td colspan="1">

  </td>

  {{-- DEAD DEVICES --}}
  <td colspan="1">

  </td>
</tr>
