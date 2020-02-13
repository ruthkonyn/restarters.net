<section class="table-section py-30" id="all-groups">
  <p class="mb-30">
    There are <span class="font-weight-bold">{{ $groups_count }} groups</span>
  </p>

  @include('group.group-filters')

  <div class="d-block d-md-none text-right mt-10">
    <a class="collapse-plus-and-minus-controller" data-toggle="collapse" href="#collapseSearchFilters" aria-expanded="true" aria-controls="collapseSearchFilters">
      Close Filters
    </a>

    <hr class="m-0 hr-sm">
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
