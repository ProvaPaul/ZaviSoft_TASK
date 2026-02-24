<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Foodpanda App</title>

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
                <div class="w-16 h-16 bg-orange-500 rounded-2xl flex items-center justify-center shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.65V9.35m0 0a3.001 3.001 0 003.75-.615A2.993 2.993 0 009.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 002.25 1.016c.896 0 1.7-.393 2.25-1.016a3.001 3.001 0 003.75.614m-16.5 0a3.004 3.004 0 01-.621-4.72L4.318 3.44A1.5 1.5 0 015.378 3h13.243a1.5 1.5 0 011.06.44l1.19 1.189a3 3 0 01-.621 4.72m-13.5 8.65h3.75a.75.75 0 00.75-.75V13.5a.75.75 0 00-.75-.75H6.75a.75.75 0 00-.75.75v3.75c0 .415.336.75.75.75z" />
                    </svg>
                </div>
            </div>

            {{-- White Card --}}
            <div class="w-full sm:max-w-lg bg-white shadow-md rounded-lg overflow-hidden">
                <div class="px-8 py-10 text-center">
                    <h1 class="text-2xl font-bold text-gray-900">Foodpanda App</h1>
                    <p class="mt-2 text-sm text-gray-500">OAuth2 SSO Client</p>

                    <div class="mt-8 border-t border-gray-100 pt-8">
                        <p class="text-sm text-gray-600 leading-relaxed">
                            This application uses <span class="font-semibold text-gray-800">Single Sign-On</span> via
                            the Ecommerce Authorization Server.
                        </p>

                        <div class="mt-6 flex flex-col items-center gap-4">
                            <a href="http://127.0.0.1:8000/login"
                                class="inline-flex items-center gap-2 px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-md shadow-sm transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                    stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                                </svg>
                                Login via Ecommerce
                            </a>
                            <p class="text-xs text-gray-400">
                                Sign in at the Ecommerce app, then click "Go to Foodpanda"
                            </p>
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