{{-- 

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Student Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    Welcome to Student Dashboard!
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
 --}}


 
 @extends('layouts.app')
 
 @section('title', 'Student Dashboard')
 
 @section('content')
     <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
         <h1 class="text-3xl font-bold text-gray-900 mb-8">Student Dashboard</h1>
 
         <!-- Flash Messages -->
         {{-- @if(session('success'))
             <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded relative" role="alert">
                 {{ session('success') }}
                 <button type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3 text-green-700 hover:text-green-900" onclick="this.parentElement.style.display='none';">
                     <span class="text-2xl">×</span>
                 </button>
             </div>
         @endif
         @if($errors->any())
             <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded relative" role="alert">
                 <ul class="list-disc pl-5">
                     @foreach($errors->all() as $error)
                         <li>{{ $error }}</li>
                     @endforeach
                 </ul>
                 <button type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3 text-red-700 hover:text-red-900" onclick="this.parentElement.style.display='none';">
                     <span class="text-2xl">×</span>
                 </button>
             </div>
         @endif --}}



         <!-- Toast Notifications (Top Center) - Pure Tailwind -->
         <div class="fixed inset-x-0 top-4 flex flex-col items-center gap-4 z-50 pointer-events-none px-4">
             @if(session('success'))
                 <div class="max-w-md w-full bg-green-600 text-white px-6 py-4 rounded-lg shadow-2xl flex items-center gap-4 pointer-events-auto animate-pulse-once">
                     <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                     </svg>
                     <p class="font-medium text-lg">{{ session('success') }}</p>
                     <button type="button" class="ml-auto text-white hover:text-green-200 transition-colors" onclick="this.closest('.pointer-events-auto').remove()">
                         <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                         </svg>
                     </button>
                 </div>
             @endif
         
             @if($errors->any())
                 <div class="max-w-md w-full bg-red-600 text-white px-6 py-4 rounded-lg shadow-2xl flex items-start gap-4 pointer-events-auto animate-pulse-once">
                     <svg class="w-6 h-6 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                     </svg>
                     <div>
                         <p class="font-medium text-lg">Please fix the errors below:</p>
                         <ul class="list-disc list-inside text-sm mt-2 space-y-1">
                             @foreach($errors->all() as $error)
                                 <li>{{ $error }}</li>
                             @endforeach
                         </ul>
                     </div>
                     <button type="button" class="ml-auto text-white hover:text-red-200 transition-colors" onclick="this.closest('.pointer-events-auto').remove()">
                         <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                         </svg>
                     </button>
                 </div>
             @endif
         </div>
 
         <!-- Active Modules -->
         <div class="mb-12">
             <h2 class="text-2xl font-semibold mb-4">Active Modules ({{ $activeEnrollments->count() }}/4)</h2>
             @if ($activeEnrollments->isNotEmpty())
                 <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                     @foreach ($activeEnrollments as $enrollment)
                         <div class="bg-white shadow rounded-lg p-6">
                             <h3 class="text-xl font-semibold">{{ $enrollment->module->module }}</h3>
                             <p class="text-sm text-gray-600 mt-2">
                                 Enrolled on: {{ $enrollment->enrolled_at->format('d M Y') }}
                             </p>
                         </div>
                     @endforeach
                 </div>
             @else
                 <p class="text-gray-600">You have no active modules.</p>
             @endif
         </div>
 
         <!-- Completed Modules History -->
         <div class="mb-12">
             <h2 class="text-2xl font-semibold mb-4">Completed Modules History</h2>
             @if ($completedEnrollments->isNotEmpty())
                 <div class="overflow-x-auto">
                     <table class="min-w-full bg-white shadow rounded-lg">
                         <thead class="bg-gray-50">
                             <tr>
                                 <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Module</th>
                                 <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Enrolled On</th>
                                 <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Result</th>
                                 <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Completed On</th>
                             </tr>
                         </thead>
                         <tbody class="divide-y divide-gray-200">
                             @foreach ($completedEnrollments as $enrollment)
                                 <tr>
                                     <td class="px-6 py-4 whitespace-nowrap font-medium">{{ $enrollment->module->module }}</td>
                                     <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                         {{ $enrollment->enrolled_at->format('d M Y') }}
                                     </td>
                                     <td class="px-6 py-4 whitespace-nowrap">
                                         @if ($enrollment->completed_at)
                                             <span class="{{ $enrollment->pass ? 'text-green-600' : 'text-red-600' }} font-medium">
                                                 {{ $enrollment->pass ? 'PASS' : 'FAIL' }}
                                             </span>
                                         @else
                                             Pending
                                         @endif
                                     </td>
                                     <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                         {{ $enrollment->completed_at ? $enrollment->completed_at->format('d M Y') : 'N/A' }}
                                     </td>
                                 </tr>
                             @endforeach
                         </tbody>
                     </table>
                 </div>
             @else
                 <p class="text-gray-600">You have no completed modules.</p>
             @endif
         </div>
 
         <!-- Available Modules (only for current students) -->
         @if (auth()->user()->role === 'student')
             <div>
                 <h2 class="text-2xl font-semibold mb-4">Available Modules</h2>
                 @if ($availableModules->isNotEmpty())
                     <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                         @foreach ($availableModules as $module)
                             <div class="bg-white shadow rounded-lg p-6">
                                 <h3 class="text-xl font-semibold">{{ $module->module }}</h3>
                                 <p class="text-sm text-gray-600 mt-2">
                                     Enrolled Students: {{ $module->enrollments->whereNull('completed_at')->count() }}/10
                                 </p>
                                 <form method="POST" action="{{ route('student.enrol', $module->id) }}" class="mt-4">
                                     @csrf
                                     <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded hover:bg-indigo-700 disabled:bg-gray-400 disabled:cursor-not-allowed"
                                             {{ $module->enrollments->whereNull('completed_at')->count() >= 10 ? 'disabled' : '' }}>
                                         {{ $module->enrollments->whereNull('completed_at')->count() >= 10 ? 'Full' : 'Enroll' }}
                                     </button>
                                 </form>
                             </div>
                         @endforeach
                     </div>
                 @else
                     <p class="text-gray-600">No available modules at the moment.</p>
                 @endif
             </div>
         @endif
     </div>
 @endsection

