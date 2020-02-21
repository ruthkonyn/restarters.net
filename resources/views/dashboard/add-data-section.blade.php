<div class="card card-info-box bg-primary">
  <div class="card-body text-dark">
    <div class="d-flex flex-column flex-lg-row align-items-center">
      <h2 class="mb-0 mr-30">
        Add Data
      </h2>

      <div class="mr-auto d-none d-lg-block">
        @include('svgs.fixometer.fixometer-doodle')
      </div>
    </div>

    <hr class="hr-dashed my-25">

    <p>And see your impact in the Fixometer:</p>

    <div class="flex-dynamic-row">
      <div class="flex-dynamic">
        <label for="items_cat" class="sr-only">@lang('devices.group'):<</label>
        <div class="form-control form-control__select">
          <select id="group" name="group" class="form-control select2-group change-group" title="Choose group...">
            @if( ! $user_groups->isEmpty() )
              @foreach($user_groups as $group)
                <option value="{{ $group->idgroups }}">
                  {{ $group->name }}
                </option>
              @endforeach
            @endif
          </select>
        </div>
      </div>

      <div class="flex-dynamic">
        <label for="items_cat" class="sr-only">@lang('devices.category'):</label>
        <div class="form-control form-control__select">
          <select id="events" name="events" class="form-control select2 change-events" title="Choose event...">
          </select>
        </div>
      </div>

      {{-- TODO: Add Data URL --}}
      <a href="#" class="btn btn-primary btn-sm w-min-auto">
        Add
      </a>
    </div>
  </div>
</div>
