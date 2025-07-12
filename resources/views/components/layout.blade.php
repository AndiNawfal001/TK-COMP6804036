<!doctype html>
<html lang="en" >
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Rekrutin.</title>
    {{--  DAISYUI  --}}
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    {{--  TAILWIND  --}}
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    {{--  THEME  --}}
    <script src="https://cdn.jsdelivr.net/npm/theme-change@2.0.2/index.js"></script>
    {{--  ICON  --}}
    <link rel="stylesheet" href="https://cdn-uicons.flaticon.com/uicons-solid-rounded/css/uicons-solid-rounded.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>
<body class="h-full">
<div class="min-h-full">

    @if(request()->getRequestUri() != '/')
        <x-nav-bar></x-nav-bar>
        <div class="drawer lg:drawer-open">
            <input id="my-drawer-2" type="checkbox" class="drawer-toggle" />
            <div class="drawer-content p-5 relative">
                {{ $slot }}
            </div>

            <div class="drawer-side shadow-sm">
                <x-side-bar></x-side-bar>
            </div>

        </div>

    @else

        {{ $slot }}

    @endif

</div>
</body>
</html>
