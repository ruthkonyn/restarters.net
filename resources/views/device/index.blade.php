@extends('layouts.app')

@section('title')
  Fixometer
@endsection

@section('content')

  <section>
    <div class="container">
      <div class="row">
        <div class="col-12 col-md-12">
          <div class="d-flex align-items-center">
            <h1 id="dashboard__header" class="mb-0 mr-30">
              @lang('devices.devices')
            </h1>
            <div class="mr-auto d-none d-md-block">
              @include('svgs.fixometer.fixometer-doodle')
            </div>

            <button data-target="#add-device-modal" data-toggle="modal" aria-expanded="true" aria-controls="add-device-modal" class="btn btn-sm btn-primary ml-auto">
              Add Data
            </button>
          </div>

          <hr class="hr-lg">
        </div>
      </div>
    </div>
  </section>

  <form id="device-search" action="/device/search/" method="get">

    <input type="hidden" name="sort_direction" value="{{{ $sort_direction }}}">

    @php( $active_filter = false )

    @foreach( FixometerHelper::filterColumns() as $column => $label )
      <input @if( $sort_column == $column ) checked @endif type="radio" name="sort_column" value="{{{ $column }}}" id="label-{{{ $column }}}" class="sr-only">
    @endforeach

      <section>
        <div class="container">
          <div class="row justify-content-center">
            @include('device.filter-results')

            @if (str_contains(url()->current(), '/device/search'))
              <div class="col-12">
                <div class="d-flex flex-row align-items-center justify-content-between my-30">
                  <div class="btn-group btn-group__duo" role="group" aria-label="Filter options">
                    <div class="dropdown">
                      <button class="btn btn-primary dropdown-toggle" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="sr-only">
                          Items
                        </span>
                        <svg xmlns="http://www.w3.org/2000/svg" id="Layer" width="24.75" height="24.75" viewBox="0 0 24.75 24.75">
                          <defs>
                            <style>
                            .cls-1{fill:#0392a6;fill-rule:evenodd}
                            </style>
                          </defs>
                          <g id="Vrstva_343" data-name="Vrstva 343">
                            <path id="Path_246" d="M24.4 1H2.35A1.35 1.35 0 0 0 1 2.35V24.4a1.35 1.35 0 0 0 1.35 1.35H24.4a1.35 1.35 0 0 0 1.35-1.35V2.35A1.35 1.35 0 0 0 24.4 1zm-.9 15.75h-5.625v-5.625H23.5zM3.25 11.125h12.375v5.625H3.25zm20.25-2.25h-5.625V3.25H23.5zM3.25 3.25h12.375v5.625H3.25zm0 20.25V19h12.375v4.5zm14.625 0V19H23.5v4.5z" class="cls-1" data-name="Path 246" transform="translate(-1 -1)"/>
                          </g>
                        </svg>
                      </button>

                      <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                        @php( $user_preferences = session('column_preferences') )
                        @foreach( FixometerHelper::filterColumns() as $column => $label )
                          <label class="dropdown-item">
                            <input class="filter-columns" name="filter-columns[]" data-id="{{{ $column }}}" type="checkbox" value="{{{ $column }}}" class="dropdown-item-checkbox" @if( FixometerHelper::checkColumn($column, $user_preferences) || is_null($user_preferences) ) checked @endif>
                              {{{ $label }}}
                            </input>
                          </label>
                        @endforeach
                      </div>
                    </div>
                  </div>

                  @if (FixometerHelper::hasRole(Auth::user(), 'Administrator'))
                    <a href="/export/devices/?{{{ Request::getQueryString() }}}" class="btn btn-primary btn-save ml-2">
                      @lang('devices.export_device_data')
                    </a>
                  @endif
                </div>

                @if (isset($list))
                  <div class="table-responsive" id="sort-table">
                    <table class="table table-hover bootg table-devices" id="devices-table">
                      <thead>
                        <tr>
                          <th width="120"   @if( !FixometerHelper::hasRole(Auth::user(), 'Administrator') ) colspan="3" @endif>
                          </th>

                          <th scope="col" class="category" @if( !FixometerHelper::checkColumn('category', $user_preferences) ) style="display: none;" @endif>
                            <label for="label-category" class="sort-column @if( $sort_column == 'category' ) sort-column-{{{ strtolower($sort_direction) }}} @endif">
                              @lang('devices.category')
                            </label>
                          </th>
                          <th scope="col" class="brand" @if( !FixometerHelper::checkColumn('brand', $user_preferences) ) style="display: none;" @endif>
                            <label for="label-brand" class="sort-column @if( $sort_column == 'brand' ) sort-column-{{{ strtolower($sort_direction) }}} @endif">
                              @lang('devices.brand')
                            </label>
                          </th>
                          <th scope="col" class="model" @if( !FixometerHelper::checkColumn('model', $user_preferences) ) style="display: none;" @endif>
                            <label for="label-model" class="sort-column @if( $sort_column == 'model' ) sort-column-{{{ strtolower($sort_direction) }}} @endif">
                              @lang('devices.model')
                            </label>
                          </th>
                          <th scope="col" class="problem" @if( !FixometerHelper::checkColumn('problem', $user_preferences) ) style="display: none;" @endif>
                            <label for="label-problem" class="sort-column @if( $sort_column == 'problem' ) sort-column-{{{ strtolower($sort_direction) }}} @endif">
                              @include('svgs.fixometer.problem_icon')
                            </label>
                          </th>
                          <th scope="col" class="group_name" @if( !FixometerHelper::checkColumn('group_name', $user_preferences) ) style="display: none;" @endif>
                            <label for="label-group_name" class="sort-column @if( $sort_column == 'group_name' ) sort-column-{{{ strtolower($sort_direction) }}} @endif">
                              @include('svgs/navigation/groups-icon')
                            </label>
                          </th>
                          <th scope="col" class="event_date" @if( !FixometerHelper::checkColumn('event_date', $user_preferences) ) style="display: none;" @endif>
                            <label for="label-event_date" class="sort-column @if( $sort_column == 'event_date' ) sort-column-{{{ strtolower($sort_direction) }}} @endif">
                              @include('svgs/navigation/events-icon')
                            </label>
                          </th>
                          <th scope="col" class="repair_status" @if( !FixometerHelper::checkColumn('repair_status', $user_preferences) ) style="display: none;" @endif>
                            <label for="label-repair_status" class="sort-column @if( $sort_column == 'repair_status' ) sort-column-{{{ strtolower($sort_direction) }}} @endif">
                              @include('svgs/fixometer/gauge-ico')
                            </label>
                          </th>
                        </tr>
                      </thead>

                      <tbody>
                        @php( $user = Auth::user() )
                        @php( $is_admin = FixometerHelper::hasRole($user, 'Administrator') )
                        @foreach($list as $device)
                          @if ( $is_admin || $device->repaired_by == $user->id )
                            @include('partials.device-row-with-edit')
                          @else
                            @include('partials.device-row-collapse')
                          @endif
                        @endforeach
                      </tbody>
                    </table>
                  </div>

                  <br>

                  <div class="d-flex justify-content-center">
                    <nav aria-label="Page navigation example">
                      {{-- Custom pagination view --}}
                      <ul class="pagination">
                        @include('pagination', [
                          'paginator' => $list->appends(request()->input()),
                          'onEachSide' => 4
                        ])
                      </ul>
                    </nav>
                  </div>
                @endif
              </div>
            @endif
          </div>

          <div class="row">
            @include('device.global-impact')
          </div>
        </div>
      </div>
    </section>
  </form>

  @include('includes.modals.add-device')

@endsection
