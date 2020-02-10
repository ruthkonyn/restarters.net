@extends('layouts.app')

@section('title')
  Repairs
@endsection

@section('content')

  <section>
    <div class="container">
      <div class="row">
        <div class="col-12 col-md-12">
          <div class="d-flex align-items-center">
            <h1 id="dashboard__header" class="mb-0" style="margin-right: 30px;">
              @lang('devices.devices')
            </h1>
            <div class="mr-auto d-none d-md-block" style="width: 95px; height: 76px;">
              @include('svgs.fixometer.fixometer-doodle')
            </div>

            <button type="button" name="button" class="btn btn-sm btn-primary ml-auto">
              Add Data
            </button>
          </div>

          <hr style="height: 5px; border-top: 5px solid #000; margin-top: 50px; margin-bottom: 50px;">
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

            <div class="col-12">
              <div class="d-flex flex-row align-items-center justify-content-between my-30">
                <div class="btn-group btn-group__duo" role="group" aria-label="Filter options">
                  <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <span class="sr-only">
                        Items
                      </span>
                      <svg width="14" height="12" viewBox="0 0 12 10" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd" stroke-linejoin="round" stroke-miterlimit="1.414">
                        <path d="M3.163.324A.324.324 0 0 0 2.84 0H.324A.324.324 0 0 0 0 .324v1.909c0 .179.145.324.324.324H2.84a.324.324 0 0 0 .323-.324V.324zm0 3.715a.324.324 0 0 0-.323-.324H.324A.324.324 0 0 0 0 4.039v1.91c0 .178.145.323.324.323H2.84a.323.323 0 0 0 .323-.323v-1.91zm0 3.715a.323.323 0 0 0-.323-.323H.324A.324.324 0 0 0 0 7.754v1.91c0 .179.145.324.324.324H2.84a.324.324 0 0 0 .323-.324v-1.91zM11.25.324A.324.324 0 0 0 10.926 0h-6.37a.323.323 0 0 0-.323.324v1.909c0 .179.144.324.323.324h6.37a.324.324 0 0 0 .324-.324V.324zm0 3.715a.324.324 0 0 0-.324-.324h-6.37a.323.323 0 0 0-.323.324v1.91c0 .178.144.323.323.323h6.37a.324.324 0 0 0 .324-.323v-1.91zm0 3.715a.324.324 0 0 0-.324-.323h-6.37a.323.323 0 0 0-.323.323v1.91c0 .179.144.324.323.324h6.37a.324.324 0 0 0 .324-.324v-1.91z"
                        fill="#fff" />
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
                    <i class="fa fa-download"></i>
                    @lang('devices.export_device_data')
                  </a>
                @endif
              </div>

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
                          @lang('devices.comment')
                        </label>
                      </th>
                      <th scope="col" class="group_name" @if( !FixometerHelper::checkColumn('group_name', $user_preferences) ) style="display: none;" @endif>
                        <label for="label-group_name" class="sort-column @if( $sort_column == 'group_name' ) sort-column-{{{ strtolower($sort_direction) }}} @endif">
                          @lang('devices.group')
                        </label>
                      </th>
                      <th scope="col" class="event_date" @if( !FixometerHelper::checkColumn('event_date', $user_preferences) ) style="display: none;" @endif>
                        <label for="label-event_date" class="sort-column @if( $sort_column == 'event_date' ) sort-column-{{{ strtolower($sort_direction) }}} @endif">
                          @lang('devices.devices_date')
                        </label>
                      </th>
                      <th scope="col" class="repair_status" @if( !FixometerHelper::checkColumn('repair_status', $user_preferences) ) style="display: none;" @endif>
                        <label for="label-repair_status" class="sort-column @if( $sort_column == 'repair_status' ) sort-column-{{{ strtolower($sort_direction) }}} @endif">
                          @lang('devices.state')
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
                  <ul class="pagination">
                    @if (!empty($_GET))
                      {!! $list->appends(request()->input())->links() !!}
                    @else
                      {!! $list->links() !!}
                    @endif
                  </ul>
                </nav>
              </div>
            </div>
          </div>
          
          @include('device.global-impact')
        </div>
      </div>
    </section>
  </form>

@endsection
