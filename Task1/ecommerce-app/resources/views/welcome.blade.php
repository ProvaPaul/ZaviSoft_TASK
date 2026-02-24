<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ecommerce App</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="font-sans text-gray-900 antialiased">
    <div class="min-h-screen flex flex-col bg-gray-100">

        {{-- Top Navigation --}}
        <nav class="w-full flex justify-end gap-4 px-6 py-4">
            @auth
                <a href="{{ url('/dashboard') }}"
                    class="text-sm font-medium text-gray-600 hover:text-gray-900 transition">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900 transition">Log
                    in</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}"
                        class="text-sm font-medium text-gray-600 hover:text-gray-900 transition">Register</a>
                @endif
            @endauth
        </nav>

        {{-- Main Content --}}
        <div class="flex-1 flex flex-col items-center justify-center px-4 -mt-12">

            {{-- Logo / Icon --}}
            <div class="mb-6">
                <div class="w-16 h-16 bg-indigo-600 rounded-2xl flex items-center justify-center shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                    </svg>
                </div>
            </div>

            {{-- White Card --}}
            <div class="w-full sm:max-w-lg bg-white shadow-md rounded-lg overflow-hidden">
                <div class="px-8 py-10 text-center">
                    <h1 class="text-2xl font-bold text-gray-900">Ecommerce App</h1>
                    <p class="mt-2 text-sm text-gray-500">OAuth2 Authorization Server</p>

                    <div class="mt-8 border-t border-gray-100 pt-8">
                        <p class="text-sm text-gray-600 leading-relaxed">
                            Sign in to manage your account and access <span class="font-semibold text-gray-800">Single
                                Sign-On</span> for connected applications.
                        </p>

                        <div class="mt-6 flex flex-col items-center gap-3">
                            <a href="{{ route('login') }}"
                                class="inline-flex items-center gap-2 px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-md shadow-sm transition w-48 justify-center">
                                Log in
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}"
                                    class="inline-flex items-center gap-2 px-6 py-3 bg-white hover:bg-gray-50 text-gray-700 text-sm font-semibold rounded-md border border-gray-300 shadow-sm transition w-48 justify-center">
                                    Register
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- Footer --}}
            <p class="mt-8 text-xs text-gray-400">
                Laravel v{{ Illuminate\Foundation\Application::VERSION }}
            </p>
        </div>
    </div>
</body>

</html>