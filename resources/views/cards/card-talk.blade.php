<div class="card card-talk">
  <div class="card-body has-messages d-flex flex-row align-items-start align-items-md-center">
    <div class="mr-auto">
      <h5>
        <a href="{{ env('DISCOURSE_URL') }}/session/sso?return_path={{ env('DISCOURSE_URL') }}/t/{{ $hot_topic->slug }}/{{ $hot_topic->id }}">
          {{ $hot_topic->title }}
        </a>
      </h5>

      <div class="card-talk-summary">
        @if( isset($hot_topics['talk_categories'][$hot_topic->category_id]) )
          <span class="rectangle-tag">
            <span style="background: #{{ $hot_topics['talk_categories'][$hot_topic->category_id]->color }};"></span>
            {{ $hot_topics['talk_categories'][$hot_topic->category_id]->name }}
          </span>
        @endif

        {{-- TODO: Where do we retrieve these tags from? --}}
        <span class="tag">
          Open Data dive
        </span>

        <span class="tag">
          Data
        </span>
      </div>
    </div>

    <div class="d-none d-md-block mr-50">
      <div class="avatar-images-list">
        <img src="images/dashboard/user_avatar_placeholder.svg" height="25" width="25" alt="">
        <img src="images/dashboard/user_avatar_placeholder.svg" height="25" width="25" alt="">
        <img src="images/dashboard/user_avatar_placeholder.svg" height="25" width="25" alt="">
        <img src="images/dashboard/user_avatar_placeholder.svg" height="25" width="25" alt="">
        <img src="images/dashboard/user_avatar_placeholder.svg" height="25" width="25" alt="">
      </div>
    </div>

    {{-- TODO: Data needs populating --}}
    <div class="d-flex flex-column-reverse flex-md-row align-items-center">
      <div class="replies mr-0 mr-md-30">
        2
      </div>

      <div>
        30m
      </div>
    </div>
  </div>
</div>
