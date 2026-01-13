
@extends('layouts.app')
@section('title', 'Teacher Dashboard')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="bg-white shadow rounded-lg p-6 mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Teacher Dashboard</h1>
        <p class="mt-2 text-gray-600">Welcome back, {{ auth()->user()->name }}! Click a module to view and grade students.</p>
    </div>

    <!-- Flash Messages -->
  
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






    @if($modules->isEmpty())
        <div class="bg-white shadow-lg rounded-lg p-10 text-center">
            <p class="text-xl text-gray-600">No modules assigned yet.</p>
            <p class="text-gray-500 mt-2">Contact your administrator.</p>
        </div>
    @else
        {{-- <div class="grid grid-cols-1 lg:grid-cols-4 gap-6"> --}}
          <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 items-start">


            <!-- Left Sidebar: Module List -->
            <div class="lg:col-span-1">
                <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                    <!-- Header -->
                    <div class="px-6 py-4 bg-gradient-to-r from-indigo-500 to-purple-600 text-white">
                        <h2 class="text-lg font-semibold">Your Modules ({{ $modules->count() }})</h2>
                    </div>
            
                    <!-- Module Buttons -->
                    <div class="divide-y divide-gray-200">
                        @foreach($modules as $module)
                            <button
                                type="button"
                                onclick="showModule(this)"
                                class="module-btn w-full text-left px-6 py-4
                                       border-l-4 border-transparent
                                       hover:bg-indigo-50 transition-colors flex flex-col"
                                data-target="module-{{ $module->id }}">
                                
                                <!-- Module Name -->
                                <div class="font-medium text-gray-900">{{ $module->module }}</div>
                                
                                <!-- Module Info -->
                                <div class="text-sm text-gray-500 mt-1 flex items-center justify-between">
                                    <span>{{ $module->enrollments->count() }} student{{ $module->enrollments->count() == 1 ? '' : 's' }}</span>
                                    <span class="ml-2 px-2 py-0.5 text-xs rounded-full
                                        {{ $module->active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $module->active ? 'Available' : 'Unavailable' }}
                                    </span>
                                </div>
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>
            

            <!-- Right Side: Module Contents -->
            {{-- <div class="lg:col-span-3"> --}}
              <div class="lg:col-span-3 lg:min-h-[70vh]">

                @foreach($modules as $module)
                    {{-- <div id="module-{{ $module->id }}" class="module-content bg-white shadow-lg rounded-lg overflow-hidden {{ $loop->first ? '' : 'hidden' }}"> --}}
                      <div
                        id="module-{{ $module->id }}"
                        class="module-content bg-white shadow-lg rounded-lg overflow-hidden space-y-6 {{ $loop->first ? '' : 'hidden' }}">
                      
                        <div class="px-6 py-4 bg-gradient-to-r from-indigo-500 to-purple-600 text-white">
                            <h3 class="text-2xl font-bold">{{ $module->module }}</h3>
                            <div class="mt-2 flex flex-wrap gap-4 text-sm">
                                <span>Status:
                                    <span class="font-medium {{ $module->active ? 'text-green-200' : 'text-red-200' }}">
                                        {{ $module->active ? 'Available' : 'Unavailable' }}
                                    </span>
                                </span>
                                <span>•</span>
                                <span>Enrolled Students: {{ $module->enrollments->count() }}</span>
                            </div>
                        </div>
                        <div class="p-6">
                            @if($module->enrollments->isNotEmpty())
                                <h4 class="text-lg font-semibold mb-4 text-gray-800">Enrolled Students</h4>
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Enrolled Date</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider text-center">Grade</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach($module->enrollments as $enrollment)
                                                <tr class="hover:bg-gray-50 transition-colors">
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-sm font-medium text-gray-900">{{ $enrollment->student->name }}</div>
                                                        <div class="text-sm text-gray-500">{{ $enrollment->student->email }}</div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                                        {{ $enrollment->enrolled_at->format('d M Y') }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        @if($enrollment->completed_at)
                                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                                                {{ $enrollment->pass ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                                {{ $enrollment->pass ? 'PASS' : 'FAIL' }}
                                                            </span>
                                                            <div class="text-xs text-gray-500 mt-1">
                                                                {{ $enrollment->completed_at->format('d M Y') }}
                                                            </div>
                                                        @else
                                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                                Pending
                                                            </span>
                                                        @endif
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                                        @if(!$enrollment->completed_at)
                                                            <div class="flex justify-center gap-3">
                                                                <form method="POST" action="{{ route('teacher.grade', $enrollment->id) }}" class="inline">
                                                                    @csrf
                                                                    <input type="hidden" name="pass" value="1">
                                                                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors">
                                                                        PASS
                                                                    </button>
                                                                </form>
                                                                <form method="POST" action="{{ route('teacher.grade', $enrollment->id) }}" class="inline">
                                                                    @csrf
                                                                    <input type="hidden" name="pass" value="0">
                                                                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors">
                                                                        FAIL
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        @else
                                                            <span class="text-sm text-gray-500 font-medium">Graded</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-12">
                                    <p class="text-gray-500 text-lg">No students enrolled in this module yet.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>

<script>
    function showModule(button) {
        const targetId = button.getAttribute('data-target');

        // Hide all module contents
        document.querySelectorAll('.module-content').forEach(el => {
            el.classList.add('hidden');
        });

        // Show selected module
        const content = document.getElementById(targetId);
        if (content) {
            content.classList.remove('hidden');
        }

        
        document.querySelectorAll('.module-btn').forEach(btn => {
            btn.classList.remove(
                'bg-indigo-100',
                'font-medium',
                'border-indigo-600',
                'text-indigo-700'
            );
        });
        
        button.classList.add(
            'bg-indigo-100',
            'font-medium',
            'border-indigo-600',
            'text-indigo-700'
        );
        
        
    }

    // Auto-show first module on load
    document.addEventListener('DOMContentLoaded', () => {
        const firstButton = document.querySelector('.module-btn');
        if (firstButton) {
            showModule(firstButton);
        }
    });
</script>
@endsection



