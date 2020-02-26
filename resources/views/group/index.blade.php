@extends('layouts.app')

@section('title')
  Groups
@endsection

@section('content')

  <section class="groups groups-page">
    <div class="container">

      @include('partials.alerts')

      <div class="row">
        <div class="col-12 col-md-12 mb-50">
          <div class="d-flex align-items-center">
            <h1 class="mb-0 mr-30">
              Groups
            </h1>

            <div class="mr-auto d-none d-md-block">
              @include('svgs.group.group-doodle')
            </div>

            @if( FixometerHelper::hasRole(Auth::user(), 'Administrator') || FixometerHelper::hasRole(Auth::user(), 'Host') )
              <a href="{{{ route('create-group') }}}" class="btn btn-primary ml-auto">
                <span class="d-none d-lg-block">@lang('groups.create_groups')</span>
                <span class="d-block d-lg-none">@lang('groups.create_groups_mobile')</span>
              </a>
            @endif
          </div>
        </div>
      </div>

      @if ($all)
        <form action="/group/all/search" method="get" id="device-search">
          <div class="row justify-content-center">
            <div class="col-lg-3">
              @include('group.sections.sidebar-all-groups')
            </div>
            <div class="col-lg-9">
              @if( ! is_null($groups) )
                @include('group.sections.all-groups')
              @endif
            </div>
          </div>
        </form>
      @else
        <form action="/group/" method="get" id="groups-search">
          <input type="hidden" name="formHash" id="formHash" value="{{ $formHash }}">
          <input type="hidden" name="sort_direction" value="{{ $sort_direction }}" class="sr-only">
          <input type="radio" name="sort_column" value="upcoming_event" @if( $sort_column == 'upcoming_event' ) checked @endif id="label-upcoming_event" class="sr-only">
            <div class="offset-md-box-shadow no-space-mobile group-tabs">
              <ul id="tabs" class="nav nav-tabs nav-tabs-block" role="tablist">
                <li class="nav-item">
                  <a id="tab-A" href="#your-groups-pane" class="nav-link bg-white active" data-toggle="tab" role="tab">
                    <span class="d-none d-lg-block">@lang('groups.groups_title1')</span>
                    <span class="d-block d-lg-none">@lang('groups.groups_title1_mobile')</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a id="tab-B" href="#nearest-groups-pane" class="nav-link bg-white" data-toggle="tab" role="tab">
                    <span class="d-none d-lg-block">@lang('groups.groups_title2')</span>
                    <span class="d-block d-lg-none">@lang('groups.groups_title2_mobile')</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a id="tab-C" href="#all-groups-pane" class="nav-link bg-white" data-toggle="tab" role="tab">
                    <span class="d-none d-lg-block">@lang('groups.groups_title3')</span>
                    <span class="d-block d-lg-none">@lang('groups.groups_title3_mobile')</span>
                  </a>
                </li>
              </ul>
              <div class="tab-content" id="content" role="tablist">
                <div id="your-groups-pane" class="tab-pane fade show active" role="tabpanel" aria-labelledby="tab-A">
                  <div class="tab-pane-content p-30">
                    <div class="row">
                      <div class="col-12 col-md-12 form-group">
                        @if( !is_null($your_groups) )
                          <div class="row">
                            <div class="col">
                              @include('group.sections.user-groups')
                            </div>
                          </div>
                        @endif
                      </div>
                    </div>
                  </div>
                </div>
                <div id="nearest-groups-pane" class="tab-pane fade" role="tabpanel" aria-labelledby="tab-B">
                  <div class="tab-pane-content p-30">
                    <div class="row">
                      <div class="col-12 col-md-12 form-group">
                        <div class="row">
                          <div class="col">
                            @include('group.sections.groups-nearby')
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div id="all-groups-pane" class="tab-pane fade" role="tabpanel" aria-labelledby="tab-C">
                  <div class="tab-pane-content p-30">
                    <div class="row">
                      <div class="col-12 col-md-12 form-group">
                        <div class="row">
                          <div class="col">
                            @include('group.sections.all-groups')
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
        @endif

      </div>
    </section>
  @endsection
