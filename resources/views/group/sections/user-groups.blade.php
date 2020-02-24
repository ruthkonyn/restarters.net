<section class="table-section py-30" id="user-groups">

  <div class="alert alert-danger alert-custom alert-dismissible fade show mb-0" role="alert">
    <div class="d-flex flex-row flex-wrap align-items-center">
      <div class="mr-3 mb-2 mb-lg-0">
        @include('svgs.fixometer.alert-doodle')
      </div>

      <p class="mb-0">
        You are now folling Restart HQ! Space for message or notifications also in Groups near you and All groups.
      </p>
    </div>

    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>

  <div class="row border-between my-40">
    <div class="col-12 col-lg-4 d-md-block collapseReadMore collapse show" id="collapseReadMore1">
      <b>
        We are a network of local repair groups from around the world.
      </b>
    </div>
    
    <div class="col-12 col-lg-4 d-md-block collapseReadMore collapse show" id="collapseReadMore2">
      <p class="mb-0">Groups you create or follow appear below for quick access.</p>
    </div>

    <div class="col-12 col-lg-4">
      <p class="mb-0">
        If you can't see any here yet, why not <a href="#pane-B" data-toggle="tab" role="tab" aria-selected="true">follow your nearest group</a> to hear about their upcoming repair events?
      </p>
    </div>
  </div>

  <div class="d-block d-md-none text-right">
    <a class="collapse-plus-and-minus-controller" data-close-text="Read More" data-open-text="Read Less" data-toggle="collapse" href=".collapseReadMore" aria-expanded="true" aria-controls="collapseReadMore1 collapseReadMore2">
      Read Less
    </a>

    <hr class="m-0 hr-sm">
  </div>

  <div class="table-responsive">
    <table role="table" class="table table-striped table-hover">
      @include('partials.tables.head-your-groups')
      <tbody>
        @if( ! $your_groups->isEmpty() )
          @foreach ($your_groups as $group)
            @include('partials.tables.row-your-groups')
          @endforeach
        @else
          <tr>
            <td colspan="13" align="center" class="p-3">
              @lang('groups.not_joined_a_group')
              @if( FixometerHelper::hasRole(Auth::user(), 'Administrator') || FixometerHelper::hasRole(Auth::user(), 'Host') )
                <br><a href="/group/all">See all groups</a>
              @endif
            </td>
          </tr>
        @endif
      </tbody>
    </table>
  </div>

</section>
