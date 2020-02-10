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
            <div class="mr-auto" style="width: 95px; height: 76px;">
              @include('svgs.fixometer.fixometer-doodle')
            </div>

            <button type="button" name="button" class="btn btn-sm btn-primary">
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

      <section class="devices">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-12">
              <h2 style="margin-bottom: 25px;">
                Search Repair Data
              </h2>

              <div class="search-wrapper">
                <div class="nav-md-tabs">
                  <ul id="tabs" class="nav nav-tabs nav-tabs-block nav-md-tabs" role="tablist">
                    <li class="nav-item">
                      <a id="tab-A" href="#pane-A" class="nav-link active" data-toggle="tab" role="tab">
                        @lang('devices.device_info')
                      </a>

                      @if( empty($_GET) || !empty($selected_categories) || !empty($brand) || !empty($model) )
                        @php( $active_filter = true )
                      @endif
                    </li>
                    <li class="nav-item">
                      <a id="tab-B" href="#pane-B" class="nav-link" data-toggle="tab" role="tab">
                        @lang('devices.repair_info')
                      </a>

                      @if( !empty($status) || !empty($problem) || !empty($wiki) )
                        @php( $active_filter = true )
                      @endif
                    </li>
                    <li class="nav-item">
                      <a id="tab-C" href="#pane-C" class="nav-link" data-toggle="tab" role="tab">
                        @lang('devices.event_info')
                      </a>

                      @if( !empty($selected_groups) || !empty($from_date) || !empty($to_date) )
                        @php( $active_filter = true )
                      @endif
                    </li>
                    <li class="nav-item">
                      <a id="tab-D" href="#pane-D" class="nav-link" data-toggle="tab" role="tab">
                        Group Info
                      </a>
                    </li>
                  </ul>

                  <div id="content" class="tab-content" role="tablist">
                    <div id="pane-A" class="tab-pane fade show active" role="tabpanel" aria-labelledby="tab-A">
                      <div class="accordion-tab-header collapse-plus-and-minus" role="tab" id="heading-A">
                        <button class="btn" data-toggle="collapse" data-target="#collapse-A" aria-expanded="true" aria-controls="collapse-A">
                          <h5>
                            @lang('devices.device_info')
                          </h5>
                        </button>
                      </div>

                      <div id="collapse-A" class="collapse collapse-wrapper show" data-parent="#content" role="tabpanel" aria-labelledby="heading-A">
                        <div class="collapse-content">
                          <div class="row">
                            <div class="col-12 col-md-4 form-group">
                              <label for="items_cat">@lang('devices.category'):</label>
                              <div class="form-control form-control__select">
                                <select id="categories" name="categories[]" class="form-control select2-tags" multiple title="Choose categories...">
                                  @if(isset($categories))
                                    @foreach($categories as $cluster)
                                      <optgroup label="<?php echo $cluster->name; ?>">
                                        @foreach($cluster->categories as $c)
                                          <option value="<?php echo $c->idcategories; ?>" @if (!empty($selected_categories) && in_array($c->idcategories, $selected_categories)) selected @endif>
                                            <?php echo $c->name; ?>
                                          </option>
                                        @endforeach
                                      </optgroup>
                                    @endforeach
                                  @endif
                                  <option value="46">Misc</option>
                                </select>
                              </div>
                            </div>

                            <div class="col-12 col-md-4 form-group">
                              <label for="brand">@lang('devices.device_brand'):</label>
                              <input type="text" class="form-control field" id="brand" name="brand"
                              placeholder="e.g. Apple..." value="{{ $brand }}">
                            </div>

                            <div class="col-12 col-md-4 form-group">
                              <label for="model">@lang('devices.device_model'):</label>
                              <input type="text" class="form-control field" id="model" name="model"
                              placeholder="e.g. iPhone..." value="{{ $model }}">
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div id="pane-B" class="tab-pane fade" role="tabpanel" aria-labelledby="tab-B">
                      <div class="accordion-tab-header collapse-plus-and-minus" role="tab" id="heading-B">
                        <button class="btn collapsed" data-toggle="collapse" data-target="#collapse-B" aria-expanded="true" aria-controls="collapse-B">
                          <h5>
                            @lang('devices.repair_info')
                          </h5>
                        </button>
                      </div>

                      <div id="collapse-B" class="collapse collapse-wrapper" data-parent="#content" role="tabpanel" aria-labelledby="heading-B">
                        <div class="collapse-content">
                          <div class="row">
                            <div class="col-12 col-md-4 form-group">
                              <label for="status">Repair Status:</label>
                              <div class="form-control form-control__select">
                                <select id="status" name="status[]" class="form-control select2-tags" multiple title="Device status...">
                                  <option @if (! empty($status) && in_array(1, $status)) selected @endif value="1">
                                    Fixed
                                  </option>
                                  <option @if (! empty($status) && in_array(2, $status)) selected @endif value="2">
                                    Repairable
                                  </option>
                                  <option @if (! empty($status) && in_array(3, $status)) selected @endif value="3">
                                    End
                                  </option>
                                </select>
                              </div>
                            </div>

                            <div class="col-12 col-md-4 form-group">
                              <label for="problem">@lang('devices.search_comments'):</label>
                              <input type="text" class="form-control field" id="problem" name="problem"
                              placeholder="e.g. screen..." value="{{ $problem }}">
                            </div>

                            <div class="col-12 col-md-4 form-group">
                              <label for="suitable-for-wiki">@lang('devices.suitable'):</label>
                              <input type="checkbox" id="suitable-for-wiki" name="wiki" value="1" {{ $wiki ? 'checked' : '' }} />
                              <small class="form-text text-muted">@lang('devices.suitable_help')</small>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div id="pane-C" class="tab-pane fade" role="tabpanel" aria-labelledby="tab-C">
                      <div class="accordion-tab-header collapse-plus-and-minus" role="tab" id="heading-C">
                        <button class="btn collapsed" data-toggle="collapse" data-target="#collapse-C" aria-expanded="true" aria-controls="collapse-C">
                          <h5>
                            @lang('devices.event_info')
                          </h5>
                        </button>
                      </div>

                      <div id="collapse-C" class="collapse collapse-wrapper" data-parent="#content" role="tabpanel" aria-labelledby="heading-C">
                        <div class="collapse-content">
                          <div class="row">
                            <div class="col-12 col-md-4 form-group">
                              <label for="items_group">@lang('devices.group'):</label>
                              <div class="form-control form-control__select">
                                <select id="groups" name="groups[]" class="form-control select2-tags" multiple data-live-search="true" title="Choose groups...">
                                  @if(isset($groups))
                                    @foreach($groups as $g)
                                      <option value="<?php echo $g->idgroups; ?>" @if (!empty($selected_groups) && in_array($g->idgroups, $selected_groups)) selected @endif>
                                        <?php echo $g->name; ?>
                                      </option>
                                    @endforeach
                                  @endif
                                </select>
                              </div>
                            </div>

                            <div class="col-12 col-md-4 form-group">
                              <label for="from-date">@lang('devices.from_date'):</label>
                              <input type="date" class="field form-control" id="search-from-date" name="from-date"
                              value="{{ $from_date }}">
                              <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                            </div>

                            <div class="col-12 col-md-4 form-group">
                              <label for="to-date">@lang('devices.to_date'):</label>
                              <input type="date" class="field form-control" id="search-to-date" name="to-date"
                              value="{{ $to_date }}">
                              <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div id="pane-D" class="tab-pane fade" role="tabpanel" aria-labelledby="tab-D">
                      <div class="accordion-tab-header collapse-plus-and-minus" role="tab" id="heading-D">
                        <button class="btn collapsed" data-toggle="collapse" data-target="#collapse-D" aria-expanded="true" aria-controls="collapse-D">
                          <h5>
                            Group Info
                          </h5>
                        </button>
                      </div>

                      <div id="collapse-D" class="collapse collapse-wrapper" data-parent="#content" role="tabpanel" aria-labelledby="heading-D">
                        <div class="collapse-content">
                          {{-- TODO --}}
                          ...
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="summary">
                  <button type="button" name="button" class="btn btn-sm btn-primary mr-40">
                    @include('svgs.fixometer.search_ico')
                  </button>

                  <h2 class="mb-0">{{ $list->total() }} results</h2>
                </div>
              </div>
            </div>

            <div class="col-12 my-30">
              <div class="d-flex align-items-center justify-content-between">
                <h2 class="mb-0">
                  Our Global Impact
                </h2>

                <div class="text-white px-15 d-flex flex-row align-items-center" style="
                background-color: #000;
                font-family: Asap;
                font-size: 18px;
                font-weight: bold;
                font-stretch: normal;
                font-style: normal;
                line-height: 1.17;
                letter-spacing: normal;
                text-align: left;
                color: #ffffff;
                ">
                  <div class="mr-30">
                    @include('svgs.fixometer.clap_doodle')
                  </div>

                  Benin Fixers prevented 22kg of waste!
                </div>
              </div>
            </div>

            <div class="col-12">
              <div class="card card-summary">
                <div class="card-body">
                  @include('svgs.fixometer.smile_doodle')
                  <h3>16,424</h3>
                  <p>participants</p>
                </div>
              </div>

              <div class="card card-summary">
                <div class="card-body">
                  @include('svgs.fixometer.clap_doodle')
                  <h3>29,832</h3>
                  <p>hours of volunteered time</p>
                </div>
              </div>

              <div class="card card-summary">
                <div class="card-body">
                  @include('svgs.fixometer.phone_doodle')
                  <h3>13,453</h3>
                  <p>devices repaired</p>
                </div>
              </div>

              <div class="card card-summary">
                <div class="card-body">
                  {{-- TODO --}}
                  <h3>19,338 kg</h3>
                  <p>waste prevented</p>
                </div>
              </div>

              <div class="card card-summary">
                <div class="card-body">
                  {{-- TODO --}}
                  <h3>300,568 kg</h3>
                  <p>CO2 emissinos prevented</p>
                </div>
              </div>
            </div>

            <div class="col-12">
              <div class="row">
                <div class="col-12">

                  <div class="d-flex flex-row align-content-center justify-content-end">


                    <div class="btn-group btn-group__duo" role="group" aria-label="Filter options">

                      <button class="reveal-filters btn btn-secondary d-lg-none d-xl-none" type="button"
                      data-toggle="collapse" data-target="#collapseFilter" aria-expanded="false"
                      aria-controls="collapseFilter">Show filters</button>

                      <div class="dropdown">
                        <button class="btn btn-primary dropdown-toggle" id="dropdownMenu2" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false"><span class="sr-only">Items</span><svg
                        width="14" height="12" viewBox="0 0 12 10" xmlns="http://www.w3.org/2000/svg"
                        fill-rule="evenodd" clip-rule="evenodd" stroke-linejoin="round"
                        stroke-miterlimit="1.414">
                        <path d="M3.163.324A.324.324 0 0 0 2.84 0H.324A.324.324 0 0 0 0 .324v1.909c0 .179.145.324.324.324H2.84a.324.324 0 0 0 .323-.324V.324zm0 3.715a.324.324 0 0 0-.323-.324H.324A.324.324 0 0 0 0 4.039v1.91c0 .178.145.323.324.323H2.84a.323.323 0 0 0 .323-.323v-1.91zm0 3.715a.323.323 0 0 0-.323-.323H.324A.324.324 0 0 0 0 7.754v1.91c0 .179.145.324.324.324H2.84a.324.324 0 0 0 .323-.324v-1.91zM11.25.324A.324.324 0 0 0 10.926 0h-6.37a.323.323 0 0 0-.323.324v1.909c0 .179.144.324.323.324h6.37a.324.324 0 0 0 .324-.324V.324zm0 3.715a.324.324 0 0 0-.324-.324h-6.37a.323.323 0 0 0-.323.324v1.91c0 .178.144.323.323.323h6.37a.324.324 0 0 0 .324-.323v-1.91zm0 3.715a.324.324 0 0 0-.324-.323h-6.37a.323.323 0 0 0-.323.323v1.91c0 .179.144.324.323.324h6.37a.324.324 0 0 0 .324-.324v-1.91z"
                        fill="#fff" /></svg>
                      </button>
                      <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu2">
                        @php( $user_preferences = session('column_preferences') )
                        @foreach( FixometerHelper::filterColumns() as $column => $label )
                          <label class="dropdown-item">
                            <input class="filter-columns" name="filter-columns[]" data-id="{{{ $column }}}" type="checkbox" value="{{{ $column }}}"
                            class="dropdown-item-checkbox" @if( FixometerHelper::checkColumn($column, $user_preferences) || is_null($user_preferences) ) checked @endif> {{{ $label }}}</input>
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

                  <br>

                  <div class="table-responsive" id="sort-table">
                    <table class="table table-hover bootg table-devices" id="devices-table">
                      <thead>
                        <tr>

                          @if( !FixometerHelper::hasRole(Auth::user(), 'Administrator') )
                            <th width="120" colspan="3"></th>
                          @else
                            <th width="120"></th>
                          @endif

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

            </div>
          </section>

        </form>

      @endsection
