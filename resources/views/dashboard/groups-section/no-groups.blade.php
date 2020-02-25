<div class="card card-info-box mb-30">
  <div class="card-body">
    <div class="d-flex flex-column flex-lg-row align-items-center">
      <h2 class="mb-0 mr-30">
        <span class="d-none d-lg-block">@lang('dashboard.groups_box')</span>
        <span class="d-block d-lg-none">@lang('dashboard.groups_box_mobile')</span>
      </h2>

      <div class="mr-auto d-none d-lg-block">
        @include('svgs.group.group-doodle')
      </div>

      @if (! $new_groups->isEmpty())
        <div class="call_to_action call_to_action-sticky-right">
          <div class="doodle-icon">
            @include('svgs.dashboard.arrow-right-doodle')
          </div>

          Newly added: {{ $new_groups->count() }} {{ str_plural('group', $new_groups->count()) }} in your area!
        </div>
      @endif
    </div>

    <hr class="hr-dashed my-25">

    @if (! $new_groups->isEmpty())
      <div class="call_to_action d-block d-lg-none mb-25">
        <div class="doodle-icon">
          @include('svgs.dashboard.arrow-right-doodle')
        </div>

        Newly added: {{ $new_groups->count() }} {{ str_plural('group', $new_groups->count()) }} in your area!
      </div>
    @endif

    <div class="row">
      <div class="col-12 col-lg-6">
        <div class="slick-container">
          <div class="slick-your-groups">
            @for ($i=0; $i < 3; $i++)
              <div class="card card-group-slick bg-dark text-white rounded-0">
                <img class="card-img" src="images/dashboard/your-groups-carousel-placeholder.jpg" alt="Card image">
                <div class="card-img-overlay">
                  <p class="font-weight-bold">
                    You aren’t following any repair groups.
                  </p>

                  <p>
                    You’re welcome to <a href="#">follow any group in the world.</a> And new groups pop up all the time, so do check back!
                  </p>
                </div>
              </div>
            @endfor
          </div>
        </div>
      </div>

      <div class="col-12 col-lg-6 d-flex flex-column">
        <p class="font-weight-bold mb-0">
          Interested in starting a community repair group?
        </p>

        <p>
          Anyone with interest and some skills in organising can start a group. Check out our event planning kit. Then join your region’s Talk group and <a href="#">invite others in your area for a chat!</a> Or view our <a href="#">school programme planning guide.</a> When you’re ready to start a group, <a href="#">get in touch.</a>
        </p>

        <p class="font-weight-bold mb-0">
          Your region’s Talk groups:
        </p>

        {{-- TODO: $talk_groups --}}
        {{-- @php $user_groups = collect([]); @endphp --}}
        @if( ! $user_groups->isEmpty() )
          @php $take_3_groups = $user_groups->take(2); @endphp
          <div class="table-responsive mb-0 mt-10">
            <table role="table" class="table table-hover table-border-rows mb-0">
              <tbody>
                @foreach ($take_3_groups as $group)
                  @include('partials.tables.row-group-small')
                @endforeach
              </tbody>
            </table>
          </div>
        @endif
      </div>
    </div>
  </div>
</div>
