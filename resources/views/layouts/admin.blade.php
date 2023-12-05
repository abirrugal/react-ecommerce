<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        {{-- <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"> --}}
        <link rel="shortcut icon" type="image/x-icon" href="./assets/images/favicon/favicon.ico">
        <title>Admin</title>

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

</html>
