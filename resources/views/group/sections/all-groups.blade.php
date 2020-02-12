@if( ! is_null($groups) )
  <section class="table-section" id="all-groups">
    <h2>@lang('groups.groups_title3')</h2>

    <input type="hidden" name="sort_direction" value="{{$sort_direction}}" class="sr-only">
    <input type="radio" name="sort_column" value="name" @if( $sort_column == 'name' ) checked @endif id="label-name" class="sr-only">
    <input type="radio" name="sort_column" value="distance" @if( $sort_column == 'distance' ) checked @endif id="label-location" class="sr-only">
    <input type="radio" name="sort_column" value="hosts" @if( $sort_column == 'hosts' ) checked @endif id="label-hosts" class="sr-only">
    <input type="radio" name="sort_column" value="restarters" @if( $sort_column == 'restarters' ) checked @endif id="label-restarters" class="sr-only">
    <input type="radio" name="sort_column" value="upcoming_event" @if( $sort_column == 'upcoming_event' ) checked @endif id="label-upcoming_event" class="sr-only">
    <input type="radio" name="sort_column" value="created_at" @if( $sort_column == 'created_at' ) checked @endif id="label-created" class="sr-only">

    <div class="table-responsive">
      <table role="table" class="table table-striped table-hover table-layout-fixed" id="sort-table">
        @include('partials.tables.head-groups')

        <tbody>
          @if( ! $groups->isEmpty() )
            @foreach ($groups as $group)
              @include('partials.tables.row-groups')
            @endforeach
          @else
            <tr>
              <td colspan="13" align="center" class="p-3">There are no groups</td>
            </tr>
          @endif
        </tbody>
      </table>
    </div>

    <div class="d-flex justify-content-center">
      <nav aria-label="Page navigation example">
        @if (!empty($_GET))
          {!! $groups->appends(request()->input())->links() !!}
        @else
          {!! $groups->links() !!}
        @endif
      </nav>
    </div>
    <div class="d-flex justify-content-center">
      {{ $groups_count }} results
    </div>
  </section>
@endif
