<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold text-gray-900">E-Commerce Dashboard</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-0 space-y-6">

            {{-- WELCOME BANNER --}}
            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-2xl shadow-lg p-8 text-white">
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div>
                        <h2 class="text-2xl font-bold">Welcome, {{ Auth::user()->name }}!</h2>
                        <p class="text-indigo-100 mt-1 text-sm">{{ Auth::user()->email }}</p>
                    </div>
                    <span
                        class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-sm px-4 py-2 rounded-full text-sm font-medium">
                        <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                        Active Session
                    </span>
                </div>
            </div>

            {{-- MAIN ACTION CARD --}}
            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
                <div class="p-8 sm:p-10">

                    <div class="flex flex-col items-center text-center">
                        {{-- SSO Flow Diagram --}}
                        <div class="flex items-center gap-4 sm:gap-6 mb-8">
                            <div class="px-5 py-4 bg-indigo-50 border border-indigo-200 rounded-xl">
                                <p class="text-sm font-bold text-indigo-700">Ecommerce</p>
                                <p class="text-xs text-indigo-400 mt-0.5">Port 8000</p>
                            </div>

                            <div class="flex flex-col items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                                </svg>
                                <span class="text-[10px] text-gray-400 font-medium uppercase tracking-wider">SSO</span>
                            </div>

                            <div class="px-5 py-4 bg-orange-50 border border-orange-200 rounded-xl">
                                <p class="text-sm font-bold text-orange-700">Foodpanda</p>
                                <p class="text-xs text-orange-400 mt-0.5">Port 8001</p>
                            </div>
                        </div>

                        <p class="text-gray-500 text-sm max-w-md mb-8">
                            Click the button below to log in to Foodpanda automatically using your current session.
                        </p>

                        {{-- CTA BUTTON --}}
                        <a href="{{ route('redirect.foodpanda') }}"
                            class="inline-flex items-center gap-3 px-10 py-4 bg-orange-500 hover:bg-orange-600 active:bg-orange-700 text-white text-lg font-bold rounded-xl shadow-lg shadow-orange-500/30 hover:shadow-xl hover:shadow-orange-500/40 transform hover:-translate-y-0.5 transition-all duration-200">
                            🚀 Go to Foodpanda
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke-width="2.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                            </svg>
                        </a>
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>