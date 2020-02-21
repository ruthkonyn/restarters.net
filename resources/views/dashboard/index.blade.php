@extends('layouts.app')

@section('title')
  Dashboard
@endsection

@section('content')
  <section class="dashboard">

    <div class="container">
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
        <div class="col-12 col-md-8 d-flex flex-column">
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

          @include('partials.alerts.alert-danger', [
            'text' => 'Attention, Members! message about important event, eort, survey, topic, etc, <a href="#">with link</a>',
          ])

          @include('dashboard.groups-section')

          @include('dashboard.add-data-section')
        </div>

        <div class="col-12 col-md-4">
          <div class="card card-info-box">
            <img src="images/community.jpg" class="card-img-top" alt="...">
            <div class="card-body">
              <p class="font-weight-bold">
                Restarters.net is a free, open source platform for a global community making local repair events happen and campaigning for our right to repair. Check out our free event planning kit!
              </p>

              <p>
                We’re here to help with all of your hosting questions, or starting a school programme. Just get in touch.
              </p>
            </div>
          </div>

          <div class="card card-info-box">
            <div class="card-body">
              <h2>
                Getting the most from Restarters.net
              </h2>

              <hr class="hr-dashed my-25">

                <ul>
                  <li>
                    make sure you’re not missing out on our forum conversations - check your email digest settings and whitelist
                  </li>

                  <li>
                    learn more about how to share or even embed your Fixometer impact stats
                  </li>

                  <li>
                    if you’ve changed your skillset or role you’d like to play with Restart, update your skills for the best experience here.
                  </li>
                </ul>
            </div>
          </div>
        </div>
      </div>
    </div>

  </section>
@endsection
