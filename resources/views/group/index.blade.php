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


      <div class="row">
        <div class="col">
          <div class="d-flex justify-content-between align-content-center">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                @if( !is_null($your_groups) )
                  <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">FIXOMETER</a></li>
                  <li class="breadcrumb-item active" aria-current="page">@lang('groups.groups')</li>
                @else
                  <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">FIXOMETER</a></li>
                  <li class="breadcrumb-item"><a href="{{ route('groups') }}">@lang('groups.groups')</a></li>
                  <li class="breadcrumb-item active" aria-current="page">All groups</li>
                @endif
              </ol>
            </nav>
            <div class="btn-group button-group-filters">
              <button class="reveal-filters btn btn-secondary d-lg-none d-xl-none" type="button" data-toggle="collapse" data-target="#collapseFilter" aria-expanded="false" aria-controls="collapseFilter">Reveal filters</button>
              @if( FixometerHelper::hasRole(Auth::user(), 'Administrator') || FixometerHelper::hasRole(Auth::user(), 'Host') )
                <a href="{{{ route('create-group') }}}" class="btn btn-primary btn-save">@lang('groups.create_groups')</a>
              @endif
            </div>
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
              @include('group.sections.all-groups')
            </div>
          </div>
        </form>
      @else
        <form action="/group/" method="get" id="device-search">
          <input type="hidden" name="sort_direction" value="{{$sort_direction}}" class="sr-only">
          <input type="radio" name="sort_column" value="upcoming_event" @if( $sort_column == 'upcoming_event' ) checked @endif id="label-upcoming_event" class="sr-only">
<div class="collapse offset-md-box-shadow d-md-block show" id="collapseSearchFilters">
  <div class="nav-md-tabs">
    <ul id="tabs" class="nav nav-tabs nav-tabs-block nav-md-tabs" role="tablist">
      <li class="nav-item">
        <a id="tab-A" href="#pane-A" class="nav-link white active" data-toggle="tab" role="tab">
          @lang('groups.groups_title1')
        </a>
      </li>
      <li class="nav-item">
        <a id="tab-B" href="#pane-B" class="nav-link white " data-toggle="tab" role="tab">
          @lang('groups.groups_title2')
        </a>
      </li>
      <li class="nav-item">
        <a id="tab-C" href="#pane-C" class="nav-link white" data-toggle="tab" role="tab">
          @lang('groups.groups_title3')
        </a>
      </li>
    </ul>
<div id="content" class="tab-content" role="tablist">
  <div id="pane-A" class="tab-pane fade show active" role="tabpanel" aria-labelledby="tab-A">
    <div class="accordion-tab-header white collapse-plus-and-minus" role="tab" id="heading-A">
      <button class="btn" data-toggle="collapse" data-target="#collapse-A" aria-expanded="true" aria-controls="collapse-A">
        <h5>
          @lang('groups.groups_title1')
        </h5>
      </button>
    </div>
    <div id="collapse-A" class="collapse collapse-wrapper show" data-parent="#content" role="tabpanel" aria-labelledby="heading-A">
      <div class="collapse-content white">
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
</div>
  <div id="pane-B" class="tab-pane fade" role="tabpanel" aria-labelledby="tab-B">
    <div class="accordion-tab-header white collapse-plus-and-minus" role="tab" id="heading-B">
      <button class="btn collapsed" data-toggle="collapse" data-target="#collapse-B" aria-expanded="true" aria-controls="collapse-B">
        <h5>
          @lang('groups.groups_title3')
        </h5>
      </button>
    </div>
        <div id="collapse-B" class="collapse collapse-wrapper show" data-parent="#content" role="tabpanel" aria-labelledby="heading-B">
          <div class="collapse-content white">
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
</div>
<div id="pane-C" class="tab-pane fade" role="tabpanel" aria-labelledby="tab-C">
  <div class="accordion-tab-header white collapse-plus-and-minus" role="tab" id="heading-C">
    <button class="btn collapsed" data-toggle="collapse" data-target="#collapse-C" aria-expanded="true" aria-controls="collapse-C">
      <h5>
        @lang('groups.groups_title2')
      </h5>
    </button>
  </div>
      <div id="collapse-C" class="collapse collapse-wrapper show" data-parent="#content" role="tabpanel" aria-labelledby="heading-C">
        <div class="collapse-content white">
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
</div>
</div>
</form>
        @php( $user_preferences = session('column_preferences') )
      @endif

    </section>
  @endsection
