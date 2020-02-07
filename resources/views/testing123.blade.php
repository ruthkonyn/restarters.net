@extends('layouts.app')

@section('title')
  Dashboard
@endsection

@section('content')

  <section class="dashboard">
    <div class="container-fluid">
      <div class="row row-compressed">
        <div class="col">
          <div style="padding-left:10px">
            <h1 id="dashboard__header">@lang('dashboard.title')</h1>
            <p>@lang('dashboard.subtitle')</p>
          </div>
        </div>
      </div>
    </div>
  </section>

@endsection
