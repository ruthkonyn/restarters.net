@extends('layouts.app')
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

    <div class="row justify-content-center">
      <div class="col-lg-12">
          <header>
              <h1>All past events</h1>
          </header>
          <p>There are {{ $past_events_count }} past events.
          <div class="table-responsive">
          <table class="table table-events table-striped" role="table">
            @include('partials.tables.head-events', ['hide_invite' => true])
            <tbody>
              @if( !$past_events->isEmpty() )
                @foreach ($past_events as $event)
                  @include('partials.tables.row-events', ['invite' => false, 'EmissionRatio' => $EmissionRatio])
                @endforeach
              @else
                <tr>
                  <td colspan="13" align="center" class="p-3">There are currently no upcoming events for any of your groups<br><a href="{{{ route('groups') }}}">Find more groups</a></td>
                </tr>
              @endif
            </tbody>
          </table>
          </div>
        </section>
        <div class="d-flex justify-content-center">
          <nav aria-label="Page navigation example">
            {!! $past_events->links() !!}
          </nav>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
