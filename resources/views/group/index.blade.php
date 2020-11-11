@extends('layouts.app')

@section('title')
  Groups
@endsection

@section('content')

  <section class="groups">
    <div class="container">

      @if (\Session::has('success'))
      <div class="alert alert-success">
        {!! \Session::get('success') !!}
      </div>
      @endif
      @if (\Session::has('warning'))
      <div class="alert alert-warning">
        {!! \Session::get('warning') !!}
      </div>
      @endif

      <?php
        function expandGroups($groups) {
            $ret = [];

            if ($groups) {
                foreach ($groups as $group) {
                    $group_image = $group->groupImage;
                    $event = $group->getNextUpcomingEvent();

                    $ret[] = [
                        'idgroups' => $group['idgroups'],
                        'name' => $group['name'],
                        'image' => (is_object($group_image) && is_object($group_image->image)) ?
                            $group_image->image->path : null,
                        'location' => rtrim($group['location']),
                        'next_event' => $event ? $event['event_date'] : null,
                        'all_restarters_count' => $group->all_restarters_count,
                        'all_hosts_count' => $group->all_hosts_count,
                        'networks' => array_pluck($group->networks, 'id'),
                        'country' => $group->country
                    ];
                }
            }

            return $ret;
        }

        $all_groups = expandGroups($groups);

        if (!is_null($your_groups)) {
            $your_groups = expandGroups($your_groups);
        }

        if (!is_null($groups_near_you)) {
            $groups_near_you = expandGroups($groups_near_you);
        }

        $can_create = FixometerHelper::hasRole(Auth::user(), 'Administrator') || FixometerHelper::hasRole(Auth::user(), 'Host');
        $user = Auth::user();
        $myid = $user ? $user->id : null;
        $api_token = NULL;

        if ($user) {
            $api_token = $user->ensureAPIToken();
        }

        error_log("API Token " . $api_token);
      ?>

      <div class="vue">
        <GroupsPage
          :all-groups="{{ json_encode($all_groups) }}"
          :your-groups="{{ json_encode($your_groups) }}"
          :nearby-groups="{{ json_encode($groups_near_you) }}"
          your-area="{{ $your_area }}"
          :can-create="{{ $can_create ? 'true' : 'false' }}"
          :user-id="{{ $myid }}"
          tab="{{ $tab }}"
          :network="{{ $network ? $network : 'null' }}"
          :networks="{{ json_encode($networks) }}"
          start-a-group="{{ __('groups.consider_starting_a_group', ['resources_url' => env('DISCOURSE_URL').'/session/sso?return_path='.env('DISCOURSE_URL').'/t/how-to-power-up-community-repair-with-restarters-net/1228/']) }}"
          api-token="{{ $api_token }}"
        />
      </div>

      @php( $user_preferences = session('column_preferences') )

    </section>
  @endsection
