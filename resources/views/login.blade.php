<!DOCTYPE html>
<html lang="id">

<head>
    <title>Masuk</title>
    @include('layout.head')

    <style>
        .password-container {
            position: relative;
        }

        .toggle-password {
            position: absolute;
            top: 50%;
            right: 14px;
            transform: translateY(-50%);
            cursor: pointer;
            color: #555;
        }
    </style>
</head>

<body class="bg-linear-to-b from-sky-800 to-gray-100 min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-sm bg-white rounded-2xl shadow-xl p-8 space-y-6">

        <!-- Logo + Title -->
        <div class="w-44 h-fit mx-auto">
            <img class="h-full w-full" src="{{ asset('logo.png') }}" alt="Wimala Land">
        </div>

        <hr class="mx-5 shadow-2xl text-gray-100 rounded-r-xl rounded-l-xl" />

        <!-- Heading -->
        <div>
            <h2 class="text-3xl font-extrabold text-gray-900">Masuk</h2>
            <p class="text-gray-500 text-lg">Masuk ke akun Anda</p>
        </div>

        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-600 text-sm rounded-xl p-3">
                {{ $errors->first() }}
            </div>
        @endif

        <!-- Form -->
        <form method="POST" action="{{ route('signin') }}" class="space-y-5">
            @csrf

            <!-- Email -->
            <div class="space-y-1">
                <label for="email" class="text-gray-700 font-medium">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required
                    class="w-full p-3 bg-gray-100 rounded-xl focus:ring-2 focus:ring-sky-600 outline-none" />
            </div>

            <!-- Password -->
            <div class="space-y-1">
                <label for="password" class="text-gray-700 font-medium">Password</label>

                <div class="password-container">
                    <input type="password" name="password" id="password" required
                        class="w-full p-3 bg-gray-100 rounded-xl pr-12 focus:ring-2 focus:ring-sky-600 outline-none" />
                    <i id="toggle-password" class="fas fa-eye toggle-password"></i>
                </div>
            </div>

            <!-- Remember -->
            <label class="flex items-center gap-2 text-sm text-gray-600 cursor-pointer">
                <input type="checkbox" name="remember" value="1" class="rounded border-gray-300 text-sky-600 focus:ring-sky-500">
                Ingat saya
            </label>

            <!-- Submit Button -->
            <button type="submit"
                class="w-full py-3 text-white text-lg font-semibold bg-sky-700 rounded-xl shadow hover:bg-sky-800 hover:scale-[1.02] transition-all">
                Masuk
            </button>
        </form>

    </div>

    <script>
        // Password Visibility Toggle
        document.getElementById('toggle-password').addEventListener('click', function() {
            const pw = document.getElementById('password');
            const type = pw.type === 'password' ? 'text' : 'password';
            pw.type = type;

            this.classList.toggle('fa-eye-slash');
        });
    </script>

    @include('sweetalert::alert')
</body>

</html>
