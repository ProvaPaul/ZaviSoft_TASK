<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">
                    Authorization Server Dashboard
                </h2>
                <p class="text-sm text-gray-500 mt-1">
                    OAuth2 Single Sign-On Provider
                </p>
            </div>

            <div class="flex items-center gap-3 bg-gray-100 px-4 py-2 rounded-xl border">
                <div class="w-9 h-9 bg-red-600 text-white flex items-center justify-center rounded-full font-bold">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div class="text-sm">
                    <p class="font-semibold text-gray-800">{{ Auth::user()->name }}</p>
                    <p class="text-gray-500 text-xs">{{ Auth::user()->email }}</p>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-5xl mx-auto space-y-8">

            {{-- STATUS CARD --}}
            <div class="bg-white border rounded-2xl shadow-sm p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">
                            Authentication Status
                        </h3>
                        <p class="text-sm text-gray-500 mt-1">
                            You are authenticated on the Ecommerce Authorization Server.
                        </p>
                    </div>

                    <span class="inline-flex items-center gap-2 bg-green-100 text-green-700 px-4 py-2 rounded-full text-sm font-semibold">
                        <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                        Active Session
                    </span>
                </div>
            </div>

            {{-- SSO FLOW CARD --}}
            <div class="bg-white border rounded-2xl shadow-sm overflow-hidden">

                {{-- Header --}}
                <div class="px-6 py-4 border-b bg-gray-50">
                    <h3 class="text-lg font-semibold text-gray-800">
                        Single Sign-On Integration
                    </h3>
                    <p class="text-sm text-gray-500 mt-1">
                        OAuth2 Authorization Code Grant with Laravel Passport
                    </p>
                </div>

                {{-- Body --}}
                <div class="p-8">

                    {{-- Flow Visualization --}}
                    <div class="flex items-center justify-center gap-6 mb-10">

                        <div class="text-center">
                            <div class="px-6 py-4 bg-red-50 border border-red-200 rounded-xl">
                                <p class="text-sm font-semibold text-red-700">
                                    Ecommerce App
                                </p>
                                <p class="text-xs text-red-500 mt-1">
                                    Authorization Server (Port 8000)
                                </p>
                            </div>
                        </div>

                        <div class="text-gray-400 text-xl font-bold">
                            →
                        </div>

                        <div class="text-center">
                            <div class="px-6 py-4 bg-green-50 border border-green-200 rounded-xl">
                                <p class="text-sm font-semibold text-green-700">
                                    Foodpanda App
                                </p>
                                <p class="text-xs text-green-500 mt-1">
                                    OAuth Client (Port 8001)
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Explanation --}}
                    <div class="bg-gray-50 border rounded-xl p-6 mb-8">
                        <h4 class="font-semibold text-gray-800 mb-3">
                            How It Works
                        </h4>

                        <ul class="space-y-2 text-sm text-gray-600">
                            <li>• User clicks "Launch Foodpanda"</li>
                            <li>• OAuth2 authorization code is issued</li>
                            <li>• Foodpanda exchanges code for access token</li>
                            <li>• User is automatically authenticated</li>
                        </ul>
                    </div>

                    {{-- CTA --}}
                    <div class="text-center">
                        <a href="{{ route('redirect.foodpanda') }}"
                           class="inline-flex items-center gap-3 px-8 py-4 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-xl shadow-md transition duration-200">
                            Launch Foodpanda Application
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                            </svg>
                        </a>

                        <p class="text-xs text-gray-400 mt-4">
                            Redirects to http://127.0.0.1:8001 with automatic login
                        </p>
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>