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




 
@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">Admin Dashboard</h1>

        <!-- Flash Messages -->
        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
                <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                    <button type="button" class="text-green-700 hover:text-green-900" onclick="this.parentElement.parentElement.style.display='none';">
                        <span class="text-2xl">×</span>
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
                        <span class="text-2xl">×</span>
                    </button>
                </span>
            </div>
        @endif

        <!-- Add New Module -->
        <div class="bg-white shadow rounded-lg p-6 mb-8">
            <h2 class="text-xl font-semibold mb-4">Add New Module</h2>
            <form method="POST" action="{{ route('admin.modules.store') }}" class="flex gap-4">
                @csrf
                <input type="text" name="module" placeholder="Module name" required class="flex-1 border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded hover:bg-indigo-700 transition-colors">
                    Add Module
                </button>
            </form>
        </div>

        <!-- Modules List -->
        <div class="bg-white shadow rounded-lg overflow-hidden mb-8">
            <div class="px-6 py-4 border-b">
                <h2 class="text-xl font-semibold">Modules</h2>
            </div>
            <div class="divide-y divide-gray-200">
                @forelse ($modules as $module)
                    <div class="px-6 py-4">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <h3 class="font-medium">{{ $module->module }}</h3>
                                <p class="text-sm text-gray-500">
                                    Status: <span class="{{ $module->active ? 'text-green-600' : 'text-red-600' }}">{{ $module->active ? 'Available' : 'Unavailable' }}</span>
                                    | Teacher: {{ $module->teacher ? $module->teacher->name : 'None' }}
                                    | Enrolled Students: {{ $module->enrollments->count() }}
                                </p>
                            </div>


                            <div class="flex gap-3">


                                {{-- <!-- Toggle Active -->
                                <form method="PATCH" action="{{ route('admin.modules.toggle', $module->id) }}">
                                    @csrf @method('POST')
                                    <button type="submit" class="text-sm px-4 py-2 rounded font-medium transition-colors {{ $module->active ? 'bg-yellow-100 text-yellow-800 hover:bg-yellow-200' : 'bg-green-100 text-green-800 hover:bg-green-200' }}">
                                        {{ $module->active ? 'Deactivate' : 'Activate' }}
                                    </button>
                                </form> --}}

                                <!-- Toggle Active -->

                                <form method="POST" action="{{ route('admin.modules.toggle', $module->id) }}"> @csrf
                                @method('PATCH')
                                 <button type="submit" class="text-sm px-4 py-2 rounded font-medium transition-colors {{ $module->active ? 'bg-yellow-100 text-yellow-800 hover:bg-yellow-200' : 'bg-green-100 text-green-800 hover:bg-green-200' }}">
                                {{ $module->active ? 'Unavailable' : 'Available' }}
                                 </button>
                                </form>
     
                                


                                <!-- Assign Teacher -->
                                <form method="POST" action="{{ route('admin.modules.assign', $module->id) }}" class="flex gap-2">
                                    @csrf
                                    <select name="teacher_id" class="border border-gray-300 rounded px-2 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                        <option value="">None</option>
                                        @foreach ($teachers as $teacher)
                                            <option value="{{ $teacher->id }}" {{ $module->teacher_id == $teacher->id ? 'selected' : '' }}>{{ $teacher->name }}</option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 transition-colors">
                                        Assign
                                    </button>
                                </form>
                            </div>
                        </div>

                        <!-- Enrolled Students with Remove -->
                        @if ($module->enrollments->isNotEmpty())
                            <div class="mt-4 px-6">
                                <h4 class="text-lg font-medium mb-2">Enrolled Students</h4>
                                <ul class="list-disc pl-5">
                                    @foreach ($module->enrollments as $enrollment)
                                        <li class="flex justify-between items-center py-1">
                                            {{-- <span>{{ $enrollment->user->name }} ({{ $enrollment->user->email }})</span> --}}

                                            <span>{{ $enrollment->student->name }} ({{ $enrollment->student->email }})</span>
                                            <form method="POST" action="{{ route('admin.enrollments.remove', $enrollment->id) }}">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium">Remove</button>
                                            </form>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @else
                            <p class="text-sm text-gray-500 mt-4 px-6">No students enrolled</p>
                        @endif
                    </div>
                @empty
                    <div class="px-6 py-8 text-center text-gray-500">No modules yet</div>
                @endforelse
            </div>
        </div>




        <!-- Create Teacher -->
     <div class="bg-white shadow rounded-lg p-6 mb-8">
     <h2 class="text-xl font-semibold mb-4">Create New Teacher</h2>
     <form method="POST" action="{{ route('admin.teachers.store') }}">
        @csrf

        <!-- Name -->
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
            <input type="text" name="name" id="name" placeholder="Enter teacher's name" required 
                   class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>

        <!-- Email -->
        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <input type="email" name="email" id="email" placeholder="Enter teacher's email" required 
                   class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>

        <!-- Password -->
        <div class="mb-4">
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
            <input type="password" name="password" id="password" placeholder="Enter password" required 
                   class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>

        <!-- Confirm Password -->
        <div class="mb-6">
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirm password" required 
                   class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>

        <!-- Submit Button -->
        <button type="submit" class="mt-4 bg-indigo-600 text-white px-6 py-2 rounded hover:bg-indigo-700 transition-colors">
                    Create Teacher
                </button>
       </form>
      </div>

        <!-- Teachers List with Remove -->
        <div class="bg-white shadow rounded-lg overflow-hidden mb-8">
            <div class="px-6 py-4 border-b">
                <h2 class="text-xl font-semibold">Teachers</h2>
            </div>
            <div class="divide-y divide-gray-200">
                @forelse ($teachers as $teacher)
                    <div class="px-6 py-4 flex items-center justify-between">
                        <div>
                            <p class="font-medium">{{ $teacher->name }}</p>
                            <p class="text-sm text-gray-500">{{ $teacher->email }}</p>
                        </div>
                        <form method="POST" action="{{ route('admin.teachers.destroy', $teacher->id) }}">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium">Remove</button>
                        </form>
                    </div>
                @empty
                    <div class="px-6 py-8 text-center text-gray-500">No teachers yet</div>
                @endforelse
            </div>
        </div>

        <!-- Change User Roles -->
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="px-6 py-4 border-b">
                <h2 class="text-xl font-semibold">Change User Roles</h2>
            </div>
            <div class="divide-y divide-gray-200">
                @forelse ($users as $user)
                    <div class="px-6 py-4 flex items-center justify-between">
                        <div>
                            <p class="font-medium">{{ $user->name }}</p>
                            <p class="text-sm text-gray-500">{{ $user->email }} • Current: {{ $user->userRole->role }}</p>
                        </div>
                        <form method="POST" action="{{ route('admin.users.change-role', $user->id) }}" class="flex gap-2">
                            @csrf
                            <select name="role" class="border border-gray-300 rounded px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                @foreach (['admin', 'teacher', 'student', 'old_student'] as $r)
                                    <option value="{{ $r }}" {{ $user->userRole->role === $r ? 'selected' : '' }}>
                                        {{ ucfirst($r) }}
                                    </option>
                                @endforeach
                            </select>
                            <button type="submit" class="bg-indigo-600 text-white px-3 py-1 rounded hover:bg-indigo-700 transition-colors">
                            Change
                            </button>
                        </form>
                    </div>
                @empty
                    <div class="px-6 py-8 text-center text-gray-500">No users found</div>
                @endforelse
            </div>
        </div>
    </div>
@endsection


