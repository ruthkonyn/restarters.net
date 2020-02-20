{{-- Main Events Table Heading --}}
<thead>
  <tr>
    {{-- <th class="hightlighted" width="10"></th> --}}

    {{-- EVENT DATE --}}
    <th scope="col" width="70">
      &nbsp;
    </th>

    {{-- EVENT LOCATION --}}
    <th scope="col">
      &nbsp;
    </th>

    {{-- GROUP ICON --}}
    <th scope="col" width="85">
      &nbsp;
    </th>

    {{-- GROUP NAME --}}
    <th scope="col" class="d-none d-md-table-cell">
      &nbsp;
    </th>

    {{-- INVITES --}}
    <th scope="col" class="text-center d-none d-md-table-cell">
      <label>
        @include('svgs/fixometer/invites-icon')
      </label>
    </th>

    {{-- PARTCIPANTS --}}
    <th scope="col" class="text-center d-none d-md-table-cell">
      <label>
        @include('svgs/navigation/groups-icon')
      </label>
    </th>

    {{-- RSVP BUTTON --}}
    <th scope="col">
      &nbsp;
    </th>
  </tr>
</thead>
