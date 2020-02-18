<div class="card card-info-box">
  <div class="card-body">
    <div class="d-flex flex-column flex-md-row align-items-center">
      <h2 class="mb-0 mr-30">
        <span class="d-none d-lg-block">@lang('dashboard.groups_box')</span>
        <span class="d-block d-lg-none">@lang('dashboard.groups_box_mobile')</span>
      </h2>

      <div class="mr-auto d-none d-md-block">
        @include('svgs.group.group-doodle')
      </div>

      @if (! $new_groups->isEmpty())
        <div class="call_to_action d-none d-md-block" style="right: 0; position: absolute;">
          <div class="mr-30">
            {{-- TODO: Arrow doodle --}}
            {{-- Previous: @include('svgs.fixometer.clap_doodle') --}}
          </div>

          Newly added: {{ $new_groups->count() }} {{ str_plural('group', $new_groups->count()) }} in your area!
        </div>
      @endif
    </div>

    <hr class="hr-dashed my-25">

    <div class="call_to_action d-block d-md-none mb-25">
      <div class="mr-30">
        {{-- TODO: Arrow doodle --}}
        {{-- Previous: @include('svgs.fixometer.clap_doodle') --}}
      </div>

      Newly added: {{ $new_groups->count() }} {{ str_plural('group', $new_groups->count()) }} in your area!
    </div>

    <div class="row">
      <div class="col-12 col-md-6">
        <b>
          Group chat
        </b>

        <p class="card-text mb-20">
          Catch up with your groups by clicking below.
          You can also <a href="#">send an urgent message</a> to groups you host.
        </p>

        <div class="table-responsive mb-0">
          <table role="table" class="table table-striped table-hover mb-0">
            <tbody>
              @if( ! $user_groups->isEmpty() )
                @foreach ($user_groups as $group)
                  @include('partials.tables.row-group-small')
                @endforeach
              @endif
            </tbody>
          </table>
        </div>

        <a href="#" class="text-dark text-underlined float-right">
          <u>
            see all
          </u>
        </a>
      </div>

      <div class="col-12 col-md-6">
        <div class="d-flex flex-wrap flex-row align-items-center justify-content-between mb-20">
          <div class="">
            <b>
              Upcoming events
            </b>

            <p class="card-text mb-0">
              Your groups' upcoming events:
            </p>
          </div>

          @if( FixometerHelper::userCanCreateEvents(Auth::user()) )
            <a href="/party/create" class="btn btn-primary btn-sm" style="width: 80px !important; min-width: auto;">
              Add
            </a>
          @endif
        </div>

        <div class="table-responsive mb-0">
          <table role="table" class="table table-striped table-hover mb-0">
            <tbody>
              @if( ! $upcoming_events->isEmpty() )
                @foreach ($upcoming_events as $event)
                  TODO: @include('partials.tables.row-event-small')
                @endforeach
              @endif
            </tbody>
          </table>
        </div>

        <a href="#" class="text-dark text-underlined float-right">
          <u>
            see all
          </u>
        </a>
      </div>
    </div>
  </div>
</div>
