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
        <label for="items_cat" class="sr-only">@lang('devices.category'):</label>
        <div class="form-control form-control__select">
          <select id="categories" name="categories[]" class="form-control select2-categories" multiple title="Choose categories...">
            {{-- @if(isset($categories))
              @foreach($categories as $cluster)
                <optgroup label="<?php echo $cluster->name; ?>">
                  @foreach($cluster->categories as $c)
                    <option value="<?php echo $c->idcategories; ?>" @if (!empty($selected_categories) && in_array($c->idcategories, $selected_categories)) selected @endif>
                      <?php echo $c->name; ?>
                    </option>
                  @endforeach
                </optgroup>
              @endforeach
            @endif --}}
            <option value="46">Misc</option>
          </select>
        </div>
      </div>

      <div class="flex-dynamic">
        <label for="items_cat" class="sr-only">@lang('devices.category'):</label>
        <div class="form-control form-control__select">
          <select id="categories" name="categories[]" class="form-control select2-categories" multiple title="Choose categories...">
            {{-- @if(isset($categories))
              @foreach($categories as $cluster)
                <optgroup label="<?php echo $cluster->name; ?>">
                  @foreach($cluster->categories as $c)
                    <option value="<?php echo $c->idcategories; ?>" @if (!empty($selected_categories) && in_array($c->idcategories, $selected_categories)) selected @endif>
                      <?php echo $c->name; ?>
                    </option>
                  @endforeach
                </optgroup>
              @endforeach
            @endif --}}
            <option value="46">Misc</option>
          </select>
        </div>
      </div>

      <a href="/party/create" class="btn btn-primary btn-sm w-min-auto">
        Add
      </a>
    </div>
  </div>
</div>
