<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        {{-- <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"> --}}
        <link rel="shortcut icon" type="image/x-icon" href="./assets/images/favicon/favicon.ico">
        <title>{{ $title ?? 'Document' }}</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
        <link href="{{ asset('theme/dashboard/assets/libs/bootstrap-icons/font/bootstrap-icons.css') }}"
            rel="stylesheet">
        <link href="{{ asset('theme/dashboard/assets/libs/dropzone/dist/dropzone.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('theme/dashboard/assets/css/theme.css') }}">
        <script src="{{ asset('theme/dashboard/assets/libs/jquery/dist/jquery.min.js') }}"></script>
        {{-- admin sweet alert ---------------------------- --}}
        <link rel="stylesheet" type="text/css"
            href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
        @viteReactRefresh
        @vite(['resources/css/app.css', 'resources/js/app.jsx'])
        @inertiaHead
        <script>
            window.base_url = "{{ url('/') }}"
        </script>
    </head>

    <body class="bg-light">

    @inertia
            
    </body>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="{{ asset('theme/dashboard/assets/js/code.js') }}"></script>
    {{-- Admin sweet alert toast ----------------------------------------------------------- --}}
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script src="{{ asset('theme/dashboard/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('theme/dashboard/assets/libs/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
    <script src="{{ asset('theme/dashboard/assets/libs/feather-icons/dist/feather.min.js') }}"></script>
    <script src="{{ asset('theme/dashboard/assets/libs/prismjs/prism.js') }}"></script>
    <script src="{{ asset('theme/dashboard/assets/libs/dropzone/dist/min/dropzone.min.js') }}"></script>
    <script src="{{ asset('theme/dashboard/assets/libs/prismjs/plugins/toolbar/prism-toolbar.min.js') }}"></script>
    <script src="{{ asset('theme/dashboard/assets/js/theme.min.js') }}"></script>
    {{-- <script src="{{ asset('theme/dashboard/assets/js/main.js') }}"></script> --}}
    <script src="{{ asset('theme/dashboard/assets/js/feather.js') }}"></script>

    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>

</html>
