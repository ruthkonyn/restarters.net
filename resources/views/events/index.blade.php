@extends('layouts.app')

@section('title')
  Events
@endsection

@section('content')

  <section class="events events-page">
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


      <div class="row">
        <div class="col-12 col-md-12 mb-50">
          <div class="d-flex align-items-center">
            <h1 class="mb-0 mr-30">
              Events
            </h1>

            <div class="mr-auto d-none d-md-block">
              @include('svgs.fixometer.events-doodle')
            </div>

            @if( FixometerHelper::userCanCreateEvents(Auth::user()) )
              <a href="/party/create" class="btn btn-primary ml-auto">
                <span class="d-none d-lg-block">@lang('events.create_new_event')</span>
                <span class="d-block d-lg-none">@lang('events.create_new_event_mobile')</span>
              </a>
            @endif
          </div>
        </div>
      </div>

      <form action="/party/" method="get" id="events-search">
        <input type="hidden" name="formHash" id="formHash" value="{{ $formHash }}">
        <input type="hidden" name="sort_direction" value="{{ $sort_direction }}" class="sr-only">
        <input type="radio" name="sort_column" value="upcoming_event" @if( $sort_column == 'upcoming_event' ) checked @endif id="label-upcoming_event" class="sr-only">

        <div class="offset-md-box-shadow no-space-mobile">
          <ul id="tabs" class="nav nav-tabs nav-tabs-block" role="tablist">
            <li class="nav-item">
              <a id="tab-A" href="#your-events-pane" class="nav-link bg-white active" data-toggle="tab" role="tab">
                <span class="d-none d-lg-block">@lang('events.upcoming_for_your_groups')</span>
                <span class="d-block d-lg-none">@lang('events.upcoming_for_your_groups_mobile')</span>
              </a>
            </li>
            <li class="nav-item">
              <a id="tab-B" href="#nearest-events-pane" class="nav-link bg-white" data-toggle="tab" role="tab">
                <span class="d-none d-lg-block">@lang('events.other_events_near_you')</span>
                <span class="d-block d-lg-none">@lang('events.other_events_near_you_mobile')</span>
              </a>
            </li>
            <li class="nav-item">
              <a id="tab-C" href="#all-events-pane" class="nav-link bg-white" data-toggle="tab" role="tab">
                <span class="d-none d-lg-block">@lang('events.event_all')</span>
                <span class="d-block d-lg-none">@lang('events.event_all_mobile')</span>
              </a>
            </li>
          </ul>
          <div class="tab-content" id="content" role="tablist">
            <div id="your-events-pane" class="tab-pane fade show active" role="tabpanel" aria-labelledby="tab-A">
              <div class="tab-pane-content p-30">
                <div class="row">
                  <div class="col-12 col-md-12 form-group">
                    <div class="row">
                      <div class="col">
                        @include('events.sections.user-events')
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div id="nearest-events-pane" class="tab-pane fade" role="tabpanel" aria-labelledby="tab-B">
              <div class="tab-pane-content p-30">
                <div class="row">
                  <div class="col-12 col-md-12 form-group">
                    <div class="row">
                      <div class="col">
                        @include('events.sections.nearby-events')
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div id="all-events-pane" class="tab-pane fade" role="tabpanel" aria-labelledby="tab-C">
              <div class="tab-pane-content p-30">
                <div class="row">
                  <div class="col-12 col-md-12 form-group">
                    <div class="row">
                      <div class="col">
                        @include('events.sections.all-events')
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </form>
      @php( $user_preferences = session('column_preferences') )
    </div>
  </section>

@endsection
