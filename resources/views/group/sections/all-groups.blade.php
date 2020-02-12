@if( ! is_null($groups) )
  <section class="table-section py-30" id="all-groups">
    <p class="mb-30">There are <span class="font-weight-bold">{{ $groups->count() }} groups</span></p>

    <input type="hidden" name="sort_direction" value="{{$sort_direction}}" class="sr-only">
    <input type="radio" name="sort_column" value="name" @if( $sort_column == 'name' ) checked @endif id="label-name" class="sr-only">
    <input type="radio" name="sort_column" value="distance" @if( $sort_column == 'distance' ) checked @endif id="label-location" class="sr-only">
    <input type="radio" name="sort_column" value="hosts" @if( $sort_column == 'hosts' ) checked @endif id="label-hosts" class="sr-only">
    <input type="radio" name="sort_column" value="restarters" @if( $sort_column == 'restarters' ) checked @endif id="label-restarters" class="sr-only">
    <input type="radio" name="sort_column" value="upcoming_event" @if( $sort_column == 'upcoming_event' ) checked @endif id="label-upcoming_event" class="sr-only">
    <input type="radio" name="sort_column" value="created_at" @if( $sort_column == 'created_at' ) checked @endif id="label-created" class="sr-only">

    {{-- TODO: Open filters collapse --}}

    <div class="form-row mb-30">
      <div class="col-12 col-lg-3 form-group">
        <label for="inputCountry" class="sr-only">Name:</label>
        <input type="text" class="form-control" id="inputCountry" placeholder="Name">
      </div>

      <div class="col-12 col-lg-3 form-group">
        <label for="inputTag" class="sr-only">Tag:</label>
        <input type="text" class="form-control" id="inputTag" placeholder="Tag">
      </div>

      <div class="col-12 col-lg-3 form-group">
        <label for="inputTown" class="sr-only">Town:</label>
        <input type="text" class="form-control" id="inputTown" placeholder="Town">
      </div>

      <div class="col-12 col-lg-3 form-group">
        <label for="country" class="sr-only">@lang('groups.group_country'):</label>
        <div class="form-control form-control__select">
          <select id="country" name="country[]" class="form-control select2-countries" multiple title="Country">
            <option value=""></option>
            @foreach (FixometerHelper::getAllCountries() as $country_code => $country_name)
              @if( isset($selected_country) && $country_name == $selected_country )
                <option selected value="{{ $country_name }}">{{ $country_name }}</option>
              @else
                <option value="{{ $country_name }}">{{ $country_name }}</option>
              @endif
            @endforeach
          </select>
        </div>
      </div>
      <div class="col">
        <button type="submit" name="button" class="btn btn-sm btn-primary mr-40">
          @include('svgs.fixometer.search_ico')
      </button>
      </div>
    </div>

    <div class="table-responsive">
      <table role="table" class="table table-striped table-hover" id="sort-table">
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
        {{-- Custom pagination view --}}
        <ul class="pagination">
          @include('pagination', [
            'paginator' => $groups->appends(request()->input()),
            'onEachSide' => 4
          ])
        </ul>
      </nav>
    </div>
  </section>
@endif
