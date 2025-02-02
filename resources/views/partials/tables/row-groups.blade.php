<tr>
  <td class="table-cell-icon" colspan="1">
  @php( $group_image = $group->groupImage )
  @if( is_object($group_image) && is_object($group_image->image) )
    <img class="group-icon" src="{{ asset('/uploads/thumbnail_' . $group_image->image->path) }}" alt="{{{ $group->name }}}">
  @else
    <img class="group-icon" src="{{ asset('/images/placeholder-avatar.png') }}" alt="{{{ $group->name }}}">
  @endif
  </td>
  <td colspan="1"><a href="/group/view/{{{ $group->idgroups }}}" title="edit group">{{{ $group->name }}}</a></td>
  <td colspan="1">{{{ $group->getLocation() }}}</td>

  @php ($next_upcoming_event = $group->getNextUpcomingEvent())
  @if ( is_null($next_upcoming_event) )
    <td class="">
      @lang('groups.upcoming_none_planned')
    </td>
  @else
    <td class="">
        <a href="/party/view/{{ $next_upcoming_event->idevents }}">
            <div>{{ $next_upcoming_event->getEventDate('D jS M Y') }}</div>
        </a>
    </td>
  @endif

  <td class="text-center" colspan="1">
    @if ( ! in_array($group->idgroups, $your_groups_uniques) )
      <a class="btn btn-primary" href="/group/join/{{ $group->idgroups }}" id="join-group">@lang('groups.follow_group')</a>
    @endif
  </td>
  @if(  !is_null($groups) && App\Helpers\Fixometer::hasRole(Auth::user(), 'Administrator'))
      <td colspan="1">
          {{ \Carbon\Carbon::parse($group->created_at)->diffForHumans() }}
      </td>
  @endif
</tr>
