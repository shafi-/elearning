b4:<!doctype html>
<html lang="en">
  <head>
    <title>@yield('title')</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @stack('css')

    <!-- JS -->
    <script src="{{ asset('js/app.js') }}"></script>
  </head>
  <body>
    <div class="container-fluid">
      @include('frontend.navbar')

      <main class="py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-md-8">
              @yield('content')
            </div>
          </div>
        </div>
      </main>
    </div>

    @stack('js')
  </body>
</html>