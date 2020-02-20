@extends('layouts.app')

@section('title')
  Events
@endsection

@section('content')

  <section class="events events-page">
    <div class="container">
      <div class="row">
        <div class="col-12 col-md-12 mb-50">
          <div class="d-flex align-items-center">
            <h1 class="mb-0 mr-30">
              Events
            </h1>

            <div class="mr-auto d-none d-md-block">
              {{-- TODO: Doogle image --}}
            </div>

            @if( FixometerHelper::userCanCreateEvents(Auth::user()) )
              <a href="/party/create" class="btn btn-primary ml-auto">
                @lang('events.create_new_event')

                {{-- <span class="d-none d-lg-block">Create a new group</span>
                <span class="d-block d-lg-none">Add new</span> --}}
              </a>
            @endif
          </div>
        </div>
      </div>

      {{-- Events List --}}
      <div class="row justify-content-center">
        <div class="col-lg-12">

          {{-- Upcoming events for your Groups --}}
          <section class="table-section" id="events-2">
            <header>
              <h2>@lang('events.upcoming_for_your_groups')
                @if ( Auth::check() )
                  @php( $user = auth()->user() )
                  @php( $copy_link = url("/calendar/user/{$user->calendar_hash}") )
                  @php( $user_edit_link = url("/profile/edit/{$user->id}") )
                  @include('partials.calendar-feed-button', [
                    'copy_link' => $testopy_link,
                    'user_edit_link' => $user_edit_link,
                    'modal_title' => __('calendars.events_modal_title'),
                    'modal_text' => __('calendars.events_modal_text'),
                  ])
                @endif
                @if ( FixometerHelper::hasRole(Auth::user(), 'Administrator') && is_null($group) )
                  <sup>(<a href="{{{ route('all-upcoming-events') }}}">@lang('events.see_all_upcoming'))</a></sup></h2>
                @endif
              </header>

              <div class="table-responsive">
                <table class="table table-events table-striped table-layout-fixed" role="table">
                  @include('events.tables.headers.head-events-upcoming-only', ['hide_invite' => false])
                  <tbody>
                    @if( !$upcoming_events->isEmpty() )
                      @foreach ($upcoming_events as $event)
                        @include('partials.tables.row-events', ['show_invites_count' => true, 'EmissionRatio' => $EmissionRatio])
                      @endforeach
                    @else
                      <h2>@lang('events.upcoming_for_your_groups')</h2>
                    @endif
                  </tbody>
                </table>
              </div>
            </section>
            {{-- END Upcoming events for your Groups --}}

            @if( is_null($group) )
              <section class="table-section upcoming_events_in_area" id="events-3">
                <header>
                  <h2>@lang('events.other_events_near_you')</h2>
                </header>
                <div class="table-responsive">
                  <table class="table table-events table-striped" role="table">
                    @include('events.tables.headers.head-events-upcoming-only', ['hide_invite' => false])
                    <tbody>
                      @if ( is_null(auth()->user()->latitude) && is_null(auth()->user()->longitude) )
                        <tr>
                          <td colspan="13" align="center" class="p-3">Your town/city has not been set.<br><a href="{{{ route('edit-profile', ['id' => auth()->id()]) }}}">Click here to set it and find events near you.</a></td>
                        </tr>
                      @elseif( !$upcoming_events_in_area->isEmpty() )
                        @foreach($upcoming_events_in_area as $event)
                          @include('partials.tables.row-events', ['show_invites_count' => true, 'EmissionRatio' => $EmissionRatio])
                        @endforeach
                      @else
                        <tr>
                          <td colspan="13" align="center" class="p-3">@lang('events.no_upcoming_near_you', ['resources_link' => env('DISCOURSE_URL' ).'/session/sso?return_path='.env('DISCOURSE_URL').'/t/how-to-power-up-community-repair-with-restarters-net/1228/'])</td>
                        </tr>
                      @endif
                    </tbody>
                  </table>
                </div>
              </section>
            @endif

            {{-- Past events --}}
            <section class="table-section" id="events-4">
              <header>
                @if( !is_null($group) )
                  <h2>Past {{{ $group->name }}} events</h2>
                @else
                  <h2 class="mb-1">Past events <sup><a href="{{{ route('all-past-events') }}}">(See all past)</a></sup></h2>
                  <p class="mb-2">These are past events from groups you are a member of, and events that you RSVPed to.</p>
                @endif
              </header>
              <div class="table-responsive">
                <table class="table table-events table-striped table-layout-fixed" role="table">
                  @include('partials.tables.head-events', ['hide_invite' => true])
                  <tbody>
                    @if( !$past_events->isEmpty() )
                      @foreach($past_events as $event)
                        @include('partials.tables.row-events', ['show_invites_count' => false, 'EmissionRatio' => $EmissionRatio])
                      @endforeach
                    @else
                      <tr>
                        <td colspan="13" align="center" class="p-3">There are currently no past events for this group</td>
                      </tr>
                    @endif
                  </tbody>
                </table>
              </div>

              <div class="d-flex justify-content-center">
                <nav aria-label="Page navigation example">
                  {!! $past_events->links() !!}
                </nav>
              </div>
            </section>
            {{-- END Past events --}}

          </div>
        </div>
        {{-- END Events List --}}

      </div>
    </section>

  @endsection
