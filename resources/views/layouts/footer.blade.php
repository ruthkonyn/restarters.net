    @include('partials.onboarding')

    <footer></footer>

    <script src="{{ asset('js/app.js') }}"></script>

    {{-- Retrieve User Id within console --}}
    @include('footer')
    <script src="{{ asset('js/discourse.js') }}"></script>

    @yield('scripts')
  </body>
</html>
