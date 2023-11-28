<!DOCTYPE html>
<html lang="en">
    <head>
        @stack('meta')
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="shortcut icon" type="image/x-icon" href="./assets/images/favicon/favicon.ico">
        @stack('styles')
        <link href="{{ asset('theme/dashboard/assets/libs/bootstrap-icons/font/bootstrap-icons.css') }}" rel="stylesheet">
        <link href="{{ asset('theme/dashboard/assets/libs/dropzone/dist/dropzone.css') }}"  rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('theme/dashboard/assets/css/theme.css') }}">
        {{-- admin sweet alert ---------------------------- --}}
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" >

        <title>@yield('title')</title>
    </head>

    <body class="bg-light">

        <div id="db-wrapper">

            @include('layouts.sidebar')

            <div id="page-content">

                @include('layouts.navbar')

                <div class="container-fluid">

                    @yield('content')

                </div>

            </div>

        </div>

        @include('layouts.footer')

        @stack('footer_scripts')

        {{-- Admin sweet alert toast ----------------------------------------------------------- --}}
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

        <script>
            @if(Session::has('message'))
            var type = "{{ Session::get('alert-type','info') }}"
            switch(type){
               case 'info':
               toastr.info(" {{ Session::get('message') }} ");
               break;
               case 'success':
               toastr.success(" {{ Session::get('message') }} ");
               break;
               case 'warning':
               toastr.warning(" {{ Session::get('message') }} ");
               break;
               case 'error':
               toastr.error(" {{ Session::get('message') }} ");
               break;
            }
            @endif
        </script>



        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
        <script src="{{ asset('theme/dashboard/assets/js/code.js') }}"></script>
        {{-- Admin sweet alert toast ----------------------------------------------------------- --}}
    </body>
</html>


