@include('layouts.header_plain')

@yield('content')

<section class="login-page">
  <div class="container">

    @include('includes.info')

    <div class="row row-expanded pb-3">
      <div class="col-lg-6 d-flex">

        <form action="{{ route('login') }}" method="post" class="card card__login card-info-box mb-30 mb-lg-0">
          @csrf

          @if (\Session::has('success'))
            <div class="alert alert-success">
              {!! \Session::get('success') !!}
            </div>
          @endif

          {!! Honeypot::generate('my_name', 'my_time') !!}

          <legend>@lang('login.login_title')</legend>

          <div class="form-group">
            <label for="fp_email">@lang('auth.email_address'):</label>
            <input type="email" name="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" id="fp_email" value="{{ old('email') }}" required autofocus>
            @if ($errors->has('email'))
              <span class="invalid-feedback">
                <strong>{{ $errors->first('email') }}</strong>
              </span>
            @endif
          </div>

          <div class="form-group">
            <label for="password">@lang('auth.password'):</label>
            <input type="password" name="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" id="password" required>

            @if ($errors->has('password'))
              <span class="invalid-feedback">
                <strong>{{ $errors->first('password') }}</strong>
              </span>
            @endif
          </div>

          <div class="d-flex justify-content-between align-items-center flex-row mt-15">
            <div class="d-flex flex-column align-content-center">
              <a class="entry-panel__link" href="/user/recover">
                @lang('auth.forgot_password')
              </a>
              <a class="entry-panel__link" href="{{{ route('registration') }}}">
                @lang('auth.create_account')
              </a>
            </div>

            <button type="submit" class="btn btn-primary">
              @lang('auth.login')
            </button>
          </div>
        </form>

      </div>
      <div class="col-lg-6">

        <div class="card card__content card-info-box bg-primary">
          <h3>@lang('login.whatis')</h3>
          @lang('login.whatis_content')

          <a href="/about" class="card__link">@lang('login.more')</a>
        </div>

      </div>
    </div>

  </div>
  @include('partials.languages')
</section>

@include('layouts.footer')
