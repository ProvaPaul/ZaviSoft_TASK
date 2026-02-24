<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Foodpanda Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-800 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex items-center gap-3 mb-6">
                        <div
                            class="w-12 h-12 bg-pink-500 rounded-full flex items-center justify-center text-white text-xl font-bold">
                            🐼
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900">Welcome to Foodpanda!</h3>
                            <p class="text-sm text-gray-500">Logged in as: <strong>{{ Auth::user()->name }}</strong>
                                ({{ Auth::user()->email }})</p>
                        </div>
                    </div>

                    <div class="p-4 bg-green-50 border-2 border-green-200 rounded-lg">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="text-green-600 text-lg">✅</span>
                            <h4 class="font-semibold text-green-800">SSO Login Successful</h4>
                        </div>
                        <p class="text-sm text-green-700">
                            You were automatically logged in here from <strong>Ecommerce</strong> using
                            Single Sign-On (OAuth2 Authorization Code Grant with Laravel Passport).
                            No re-entry of credentials was required.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>