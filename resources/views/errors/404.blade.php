@extends('layouts.app')

@section('title', 'Page Not Found')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-purple-50 to-pink-50 flex items-center justify-center py-12">
    <div class="max-w-md w-full bg-white shadow-xl rounded-lg p-8 text-center">
        <div class="mb-6">
            <div class="h-20 w-20 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <span class="text-red-600 text-3xl">🚫</span>
            </div>
            <h1 class="text-2xl font-bold text-gray-900 mb-2">Page Not Found</h1>
            <p class="text-gray-600">Sorry, the page you're looking for doesn't exist or is under development.</p>
        </div>

        <div class="space-y-3">
            <a href="{{ route('home') }}"
               class="block w-full bg-sl-maroon text-white px-4 py-2 rounded-md hover:bg-red-800 transition-colors">
                Go Home
            </a>

            @auth
                <a href="{{ route(auth()->user()->role . '.dashboard') }}"
                   class="block w-full bg-gray-200 text-gray-800 px-4 py-2 rounded-md hover:bg-gray-300 transition-colors">
                    Go to Dashboard
                </a>
            @endauth
        </div>
    </div>
</div>
@endsection
