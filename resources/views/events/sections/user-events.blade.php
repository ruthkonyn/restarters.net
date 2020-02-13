<section class="table-section py-30" id="user-events">

  <div class="alert alert-danger alert-custom alert-dismissible fade show mb-0" role="alert">

    {{-- TODO: Awaiting megaphone doodle/icon --}}
    <p class="mb-0">
      You can now add all your upcoming events to your personal calendar!
    </p>

    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>

  {{-- TODO: Read more collapse --}}
  <div class="row my-40">
    <div class="col-12 col-lg-4">
      <b>
        Repair events are a great way to learn and share repair skills and do our bit for the planet by giving our broken stuff a new lease of life.
      </b>
    </div>

    <div class="col-12 col-lg-4">
      <p>
        Events organised by griups you run of follow appear below. If you plan on going, make sure you click the RSVP button to let the organisers know.
      </p>
    </div>

    <div class="col-12 col-lg-4">
      <p>
        Don't see an event for your group?
      </p>

      @if( FixometerHelper::userCanCreateEvents(Auth::user()) )
        <br>
        <a href="/party/create">
          Add one!
        </a>
      @endif
    </div>
  </div>

  <div class="table-responsive">
    <table role="table" class="table table-striped table-hover">
      @include('partials.tables.head-events')
      <tbody>
        @if( ! $upcoming_events->isEmpty() )
          @foreach ($upcoming_events as $event)
            @include('partials.tables.row-events')
          @endforeach
        @else
          <tr>
            <td colspan="13" align="center" class="p-3">
              @lang('events.upcoming_for_your_groups')
            </td>
          </tr>
        @endif
      </tbody>
    </table>
  </div>
</section>
