{{-- 

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Admin Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    Welcome to Admin Dashboard!
                </div>
            </div>
        </div>
    </div>
</x-app-layout> --}}




<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Admin Dashboard
        </h2>
    </x-slot>

    <!-- Flash Messages -->
    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
            <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                <button type="button" class="text-green-700 hover:text-green-900" onclick="this.parentElement.parentElement.style.display='none';">
                    <span class="text-2xl">&times;</span>
                </button>
            </span>
        </div>
    @endif

    @if ($errors->any())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded relative" role="alert">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                <button type="button" class="text-red-700 hover:text-red-900" onclick="this.parentElement.parentElement.style.display='none';">
                    <span class="text-2xl">&times;</span>
                </button>
            </span>
        </div>
    @endif

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    Welcome to Admin Dashboard!
                </div>
            </div>
        </div>
    </div>

    <!-- Create Teacher -->
    <div class="bg-white shadow rounded-lg p-6 mb-8">
        <h2 class="text-xl font-semibold mb-4">Create New Teacher</h2>
        <form method="POST" action="{{ route('admin.teachers.store') }}">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <input type="text" name="name" placeholder="Name" required class="border rounded px-4 py-2">
                <input type="email" name="email" placeholder="Email" required class="border rounded px-4 py-2">
                <input type="password" name="password" placeholder="Password" required class="border rounded px-4 py-2">
                <input type="password" name="password_confirmation" placeholder="Confirm Password" required class="border rounded px-4 py-2">
            </div>
            <button type="submit" class="mt-4 bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded">
                Create Teacher
            </button>
        </form>
    </div>
</x-app-layout>