@extends('layouts.app')

@section('title')
  Dashboard
@endsection

@section('content')
  <section class="dashboard">

    <div class="container-fluid">
      <div class="row">
        <div class="col-12 col-md-12 mb-50">
          <div class="d-none d-lg-block">
            <div class="d-flex flex-row align-items-center justify-content-center">
              @include('svgs.dashboard.arrows-doodle')
              <h1 id="dashboard__header" class="mb-0 mr-10">
                @lang('dashboard.title')
              </h1>
              @include('svgs.dashboard.confetti-doodle')
            </div>
          </div>

          <div class="d-block d-lg-none text-center">
            <h1 id="dashboard__header" class="mb-0">
              @lang('dashboard.title_mobile')
            </h1>
          </div>
        </div>
      </div>

      {{-- @include('dashboard.temporary-banner') --}}

      <div class="row">
        <div class="col-12 col-md-8">
          <div class="row">
            {{-- @if (FixometerHelper::hasRole($user, 'Administrator'))
              @include('dashboard.restarter')
            @endif
            @if (FixometerHelper::hasRole($user, 'Host'))
              @include('dashboard.host')
            @endif
            @if (FixometerHelper::hasRole($user, 'Restarter'))
              @include('dashboard.restarter')
            @endif
            <div class="col-12">
              @include('dashboard.blocks.impact')
            </div> --}}

            @include('dashboard.groups-section')
          </div>
        </div>

        <div class="col-12 col-md-4">

        </div>
      </div>
    </div>

  </section>
@endsection
