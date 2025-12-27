{{-- 

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Teacher Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    Welcome to Teacher Dashboard!
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 
 --}}


@extends('layouts.app')

@section('title', 'Teacher Dashboard')

@section('content')
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">Teacher Dashboard</h1>

        <!-- Flash Messages -->
        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <!-- Assigned Modules -->
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="px-6 py-4 border-b">
                <h2 class="text-xl font-semibold">Assigned Modules</h2>
            </div>
            <div class="divide-y divide-gray-200">
                @forelse ($modules as $module)
                    <div class="px-6 py-4">
                        <h3 class="font-medium text-lg mb-2">{{ $module->module }}</h3>
                        <p class="text-sm text-gray-500 mb-4">
                            Status: <span class="{{ $module->active ? 'text-green-600' : 'text-red-600' }}">{{ $module->active ? 'Available' : 'Unavailable' }}</span>
                            | Enrolled Students: {{ $module->enrollments->count() }}
                        </p>

                        <!-- Enrolled Students with Grade -->
                        @if ($module->enrollments->isNotEmpty())
                            <h4 class="text-md font-semibold mb-2">Enrolled Students</h4>
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Enrolled At</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($module->enrollments as $enrollment)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $enrollment->student->name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $enrollment->enrolled_at->format('d M Y') }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if ($enrollment->completed_at)
                                                    <span class="{{ $enrollment->pass ? 'text-green-600' : 'text-red-600' }} font-medium">
                                                        {{ $enrollment->pass ? 'PASS' : 'FAIL' }}
                                                    </span>
                                                    (Completed: {{ $enrollment->completed_at->format('d M Y') }})
                                                @else
                                                    Pending
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if (!$enrollment->completed_at)
                                                    <form method="POST" action="{{ route('teacher.grade', $enrollment->id) }}" class="inline">
                                                        @csrf
                                                        <input type="hidden" name="pass" value="1">
                                                        <button type="submit" class="text-green-600 hover:text-green-800 text-sm font-medium mr-4">PASS</button>
                                                    </form>
                                                    <form method="POST" action="{{ route('teacher.grade', $enrollment->id) }}" class="inline">
                                                        @csrf
                                                        <input type="hidden" name="pass" value="0">
                                                        <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium">FAIL</button>
                                                    </form>
                                                @else
                                                    Graded
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <p class="text-sm text-gray-500 px-6 py-4">No students enrolled in this module.</p>
                        @endif
                    </div>
                @empty
                    <p class="px-6 py-8 text-center text-gray-500">No modules assigned to you yet.</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection