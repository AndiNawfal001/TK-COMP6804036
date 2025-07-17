<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sign Up | Rekrutin.</title>

    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css"/>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body>
<div class="hero bg-base-200 min-h-screen">
    <div class="hero-content flex-col lg:flex-row-reverse max-w-3xl">
        <div class="text-center lg:text-left">
            <h1 class="text-4xl font-bold">Create your account!</h1>
            <p class="py-6">
                Join Rekrutin and find the right job vacancies for you. Fill your details below and start applying now.
            </p>
        </div>

        <div class="card bg-base-100 w-full max-w-sm shrink-0 shadow-2xl">
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="card-body">

                    @if($errors->any())
                        @foreach($errors->all() as $error)
                            <div role="alert" class="alert alert-error alert-soft shadow-xl">
                                <span>Error! {{ $error }}</span>
                            </div>
                        @endforeach
                    @endif

                    <fieldset class="fieldset">
                        <label class="label">Full Name</label>
                        <input type="text" name="name" class="input" placeholder="Your full name" value="{{ old('name') }}" required />

                        <label class="label">Email</label>
                        <input type="email" name="email" class="input" placeholder="Email address" value="{{ old('email') }}" required />

                        <label class="label">Phone Number</label>
                        <input type="text" name="phone" class="input" placeholder="Phone number " value="{{ old('phone') }}" />

                        <label class="label">Password</label>
                        <input type="password" name="password" class="input" placeholder="Password" onkeyup="checkPasswordMatch()" required />

                        <label class="label">Confirm Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="input" placeholder="Confirm password" onkeyup="checkPasswordMatch()" required />
                        <p id="password-error" class="text-xs text-red-500 -mt-1 hidden">Passwords do not match.</p>
                        <p id="password-success" class="text-xs text-green-500 -mt-1 hidden">Passwords matched.</p>

                        <div class="mt-2">
                            Already have an account?
                            <a href="/login" class="link link-hover text-info">Login now</a>
                        </div>

                        <button type="submit" id="register-btn" class="btn btn-neutral mt-4" disabled>Register</button>
                    </fieldset>
                    <script>
                        function checkPasswordMatch() {
                            const password = document.querySelector('input[name="password"]').value;
                            const confirmPassword = document.getElementById('password_confirmation').value;
                            const errorText = document.getElementById('password-error');
                            const successText = document.getElementById('password-success');
                            const registerButton = document.getElementById('register-btn');

                            if (confirmPassword === "") {
                                errorText.classList.add('hidden');
                                successText.classList.add('hidden');
                                registerButton.disabled = true;
                            } else if (password !== confirmPassword) {
                                errorText.classList.remove('hidden');
                                successText.classList.add('hidden');
                                registerButton.disabled = true;
                            } else {
                                errorText.classList.add('hidden');
                                successText.classList.remove('hidden');
                                if(){
                                    registerButton.disabled = false;
                                }
                            }
                        }


                    </script>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>
