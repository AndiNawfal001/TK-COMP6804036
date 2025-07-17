<!doctype html>
<html lang="en" >
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Rekrutin.</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body>
<div class="hero bg-base-200 min-h-screen">
    <div class="hero-content text-center">
        <div class="max-w-md">
            <p class="text-primary text-semibold text-2xl font-mono mb-4">419</p>
            <h1 class="text-5xl font-bold">Oops! Your session has expired.</h1>
            <p class="py-6">
                Please refresh the page or login again.
            </p>
            <button class="btn btn-primary"><a href="{{ route('login') }}">Go Back Login</a></button>
        </div>
    </div>
</div>
</body>
</html>
