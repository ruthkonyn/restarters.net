<!-- Modal -->
<div class="modal fade" id="group-share-stats" tabindex="-1" role="dialog" aria-labelledby="groupShareStatsLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">

    <div class="modal-content">

      <div class="modal-header">

        <h5 id="groupShareStatsLabel">@lang('groups.share_stats_header')</h5>
        @include('partials.cross')

      </div>

      <div class="modal-body">

        <p>@lang('groups.share_stats_message', ['group' => 'The Mighty Restarters'])</p>

        <div id="accordionGroup" class="accordion__share mt-4">

          <div class="card">
            <div class="card-header p-0" id="headingGroupHeadline">
              <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseGroupHeadline" aria-expanded="false" aria-controls="collapseGroupHeadline">
                @lang('groups.headline_stats_dropdown')
                @include('partials.caret')
              </button>
            </div>
            <div id="collapseGroupHeadline" class="collapse" aria-labelledby="headingGroupHeadline" data-parent="#accordionGroup">
              <div class="card-body">

                  <div class="form-group">
                      <label for="group_headline_stats_embed">@lang('groups.embed_code_header'):</label>
                      <input type="text" class="form-control field" id="group_headline_stats_embed" value='<iframe src="https://community.therestartproject.org/group/stats/1" frameborder="0" width="100%" height="115"></iframe>'>
                  </div>
                  <small class="after-offset">@lang('groups.headline_stats_message')</small>

                  <iframe src="https://community.therestartproject.org/group/stats/1" frameborder="0" width="100%" height="115" class="form-control"></iframe>

              </div>
            </div>
          </div>

          <div class="card">
            <div class="card-header p-0" id="headingGroupCO2">
              <button class="btn btn-link" data-toggle="collapse" data-target="#collapseGroupCO2" aria-expanded="true" aria-controls="collapseGroupCO2">
                @lang('groups.co2_equivalence_visualisation_dropdown')
                @include('partials.caret')
              </button>
            </div>

            <div id="collapseGroupCO2" class="collapse show" aria-labelledby="headingGroupCO2" data-parent="#accordionGroup">
              <div class="card-body">

                  <div class="form-group">
                      <label for="group_co2_stats_embed">@lang('groups.embed_code_header'):</label>
                      <input type="text" class="form-control field" id="group_co2_stats_embed" value='<iframe src="https://community.therestartproject.org/outbound/info/group/1" frameborder="0" width="700" height="850"></iframe>'>
                  </div>
                  <small class="after-offset">@lang('groups.infographic_message')</small>

                  <div class="embed-responsive embed-responsive-21by9">
                    <iframe src="https://community.therestartproject.org/outbound/info/group/1" frameborder="0" width="700" height="850" class="form-control embed-responsive-item"></iframe>
                  </div>

              </div>
            </div>
          </div>

        </div>

      </div>


    </div>
  </div>
</div>
