<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('error'))
                <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <p class="mb-6">{{ __("You're logged in!") }}</p>

                    {{-- Go to Foodpanda - SSO Multi-Login --}}
                    <div class="flex items-center gap-4 p-4 bg-green-50 border-2 border-green-200 rounded-lg">
                        <div class="flex-1">
                            <h3 class="font-semibold text-gray-900">Single Sign-On (SSO)</h3>
                            <p class="text-sm text-gray-600 mt-1">Click below to go to Foodpanda without re-entering your credentials.</p>
                        </div>
                        <a href="{{ route('redirect.foodpanda') }}"
                           class="inline-flex items-center px-6 py-3 bg-green-600 border border-transparent rounded-lg font-semibold text-sm text-white uppercase tracking-wider hover:bg-green-700 focus:bg-green-700 active:bg-green-800 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-md">
                            Go to Foodpanda
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
