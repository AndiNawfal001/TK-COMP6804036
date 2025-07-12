<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Rekrutin.</title>

    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css"/>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body>
<div class="hero bg-base-200 min-h-screen">
    <div class="hero-content flex-col lg:flex-row-reverse max-w-3xl">
        <div class="text-center lg:text-left">
            <h1 class="text-5xl font-bold">Login now!</h1>
            <p class="py-6">
                Provident cupiditate voluptatem et in. Quaerat fugiat ut assumenda excepturi exercitationem
                quasi. In deleniti eaque aut repudiandae et a id nisi.
            </p>
        </div>
        <div class="card bg-base-100 w-full max-w-sm shrink-0 shadow-2xl">
            <form method="POST" action="login">
                @csrf
                <div class="card-body">

                    @if($errors->any())
                        @foreach($errors->all() as $error)
                            <div id="error-alert" role="alert" class="alert alert-error alert-soft shadow-xl ">
                                <span>Error! {{ $error }}</span>
                            </div>
                            <script>
                                document.addEventListener('DOMContentLoaded', function () {
                                    const alertBox = document.getElementById('error-alert');
                                    if (alertBox) {
                                        setTimeout(() => {
                                            alertBox.style.display = 'none';
                                        }, 2000);
                                    }
                                });
                            </script>
                        @endforeach
                    @endif
                    <fieldset class="fieldset">
                        <label class="label">Email</label>
                        <input type="email" name="email" class="input" placeholder="Email" autocomplete="off" value="andi@admin.com" required/>

                        <label class="label">Password</label>
                        <input type="password" name="password" class="input" placeholder="Password" value="andi" required/>

                        <div>Don't Have an account yet? <a target="_blank" class="link link-hover text-info">Sign up now</a></div>

                        <button type="submit" class="btn btn-neutral mt-4">Login</button>
                    </fieldset>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>
