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

      <div class="row">
        <div class="col-12 col-md-12 p-0 p-md-15">
          @include('partials.alerts.alert-danger', [
            'text' => 'Attention, Members! message about important event, eort, survey, topic, etc, <a href="#">with link</a>',
          ])
        </div>
      </div>

      {{-- @include('dashboard.temporary-banner') --}}

      <div class="row">
        <div class="col-12 col-lg-8 d-flex flex-column order-2 order-lg-1">

          {{-- Host with groups and no events --}}
          @if (FixometerHelper::hasRole(Auth::user(), ['Administrator', 'Host']) && $user_groups->count() >= 1 && $user_upcoming_events->count() == 0)

            @include('dashboard.groups-section.user-groups', ['show_new_groups_count' => false])

          {{-- Host/ Fixer/ All Others with 1 group and upcoming events --}}
          @elseif (FixometerHelper::hasRole(Auth::user(), ['Host', 'Administrator', 'Restarter']) && $user_groups->count() >= 1 && $user_upcoming_events->count() >= 1)
            @include('dashboard.groups-section.user-groups', ['show_new_groups_count' => true])

          {{-- Anyone who hasn’t followed a group --}}
          @else

            @include('dashboard.groups-section.no-groups')
          @endif

          @include('dashboard.add-data-section')
        </div>

        <div class="col-12 col-lg-4 order-1 mb-35 mb-lg-0">
          <div class="d-none d-lg-block">
            <div class="card card-info-box bg-info">
              <img src="images/community.jpg" class="card-img-top" alt="...">
              <div class="card-body">
                <p class="font-weight-bold">
                  @lang('dashboard.first_card_title_bold')
                </p>

                <p>
                  @lang('dashboard.first_card_title_description')
                </p>
              </div>
            </div>
          </div>

          <div class="card card-info-box bg-warning">
            <div class="card-body position-relative">
              <div class="d-flex align-items-center justify-content-between">
                <h2 class="mb-0 mr-0 mr-lg-25">
                  Getting the most from Restarters.net
                </h2>

                <div class="d-none d-xl-block position-absolute top-0 right-0">
                  @include('svgs.dashboard.hand_doodle')
                </div>
              </div>


              <hr class="hr-dashed my-25">

              <p class="d-block d-lg-none">
                @lang('dashboard.second_card_title')
              </p>

              <div class="d-block d-md-none text-right">
                <a class="collapse-plus-and-minus-controller collapsed" data-close-text="Read Less" data-open-text="Read More" data-toggle="collapse" href="#collapseReadMore" aria-expanded="true" aria-controls="collapseReadMore">
                  Read More
                </a>

                <hr class="mt-0 mb-30 hr-sm">
              </div>

              <div class="d-md-block collapse" id="collapseReadMore">
                <ul class="list-doodle">
                  <li>
                    make sure you’re not missing out on our forum conversations - <a href="#">check your email digest</a> settings and whitelist
                  </li>

                  <li>
                    learn more about <a href="#">how to share or even embed your Fixometer impact stats</a>
                  </li>

                  <li>
                    if you’ve changed your skillset or role you’d like to play with Restart, <a href="#">update your skills</a> for the best experience here.
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row mt-50">
        <div class="col">
          <div class="d-flex align-items-center">
            <h1 id="dashboard__header" class="hot-topics-header mb-0 mr-30">
              @lang('partials.hot_topics')
            </h1>
            <div class="mr-auto d-none d-md-block">
              @include('svgs.dashboard.talk_doodle')
            </div>

            <a href="{{ env('DISCOURSE_URL')}}/session/sso?return_path=https://talk.restarters.net/top/weekly" class="text-dark ml-auto">
              @lang('partials.hot_topics_link')
            </a>
          </div>

          <hr class="hr-dashed my-25">

          <div class="d-none d-md-block mb-25">
            <div class="d-flex flex-row align-items-center justify-content-end">
              <div class="mr-40">
                @include('svgs.navigation.talk-icon')
              </div>

              <div class="mr-25">
                @include('svgs.talk.time_icon')
              </div>
            </div>
          </div>

          <div class="row">
            @php( $count_hot_topics = 1 )
            {{-- {{ dd($hot_topics) }} --}}
            @foreach( $hot_topics['talk_hot_topics'] as $hot_topic )
              @if ($count_hot_topics > 4)
                @break
              @endif

              <div class="col-12 mb-20">
                @include('cards.card-talk')
              </div>
              @php( $count_hot_topics++ )
            @endforeach
          </div>
        </div>
      </div>
    </div>

  </section>

@endsection
