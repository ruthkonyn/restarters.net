    @include('partials.onboarding')

    <footer></footer>

    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('global/js/app.js') }}"></script>

    {{-- Retrieve User Id within console --}}
    <script src="{{ asset('js/discourse.js') }}"></script>

    @yield('scripts')
  </body>
</html>
