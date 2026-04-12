<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    
    <!-- <script src="{{ asset('js/app.js') }}" defer></script> -->

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">
    <link rel="https://cdn.rawgit.com/mfd/f3d96ec7f0e8f034cc22ea73b3797b59/raw/856f1dbb8d807aabceb80b6d4f94b464df461b3e/gotham.css">

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    
    @yield('header')

    <script>
        window.App = {!! json_encode([
            'isAdmin' => Auth::check() ? Auth::user()->hasRole('admin') : false
        ]) !!};
  </script>
  <style>
	#interactive.viewport {position: relative; width: 100%; height: auto; overflow: hidden; text-align: center;}
	#interactive.viewport > canvas, #interactive.viewport > video {max-width: 100%;width: 100%;}
	canvas.drawing, canvas.drawingBuffer {position: absolute; left: 0; top: 0;}
  </style>
    
</head>
<body>
    <div id="app">
        @include('layouts.partials.navbar')

        <main class="py-4">
            @yield('content')
        </main>

        <flash message="{{ session()->get('flash_message') }}" type="{{ session()->get('flash_message_level') }}" ></flash>
        @if(Auth::check() && auth()->user()->hasRole('admin'))
            <caja-modal></caja-modal>
        @endif
    </div>

     <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}"></script>
    <script src="https://cdn.rawgit.com/serratus/quaggaJS/0420d5e0/dist/quagga.min.js"></script>
    <script src="https://kit.fontawesome.com/d875bf0832.js" crossorigin="anonymous"></script>
    <script>
    
         $('#cajaModal').on('show.bs.modal', function (e) {

            var button = $(e.relatedTarget)
            
            window.events.$emit('showCajaModal');
        })
    </script>
   
     @yield('scripts')
</body>
</html>
