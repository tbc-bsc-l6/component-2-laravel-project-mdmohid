
@extends('layouts.app')
@section('title', 'Student Dashboard')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="bg-white shadow rounded-lg p-6 mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Student Dashboard</h1>
        <p class="mt-2 text-gray-600">Welcome back, {{ auth()->user()->name }}! View your modules and grades.</p>
    </div>

    <!-- Toast Notifications (Top Center) -->
    <div class="fixed inset-x-0 top-4 flex flex-col items-center gap-4 z-50 pointer-events-none px-4">
        @if(session('success'))
            <div class="max-w-md w-full bg-green-600 text-white px-6 py-4 rounded-lg shadow-2xl flex items-center gap-4 pointer-events-auto animate-slide-down">
                <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p class="font-medium text-lg">{{ session('success') }}</p>
                <button type="button" class="ml-auto text-white hover:text-green-200" onclick="this.closest('.pointer-events-auto').remove()">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        @endif
        @if($errors->any())
            <div class="max-w-md w-full bg-red-600 text-white px-6 py-4 rounded-lg shadow-2xl flex items-start gap-4 pointer-events-auto animate-slide-down">
                <svg class="w-6 h-6 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                <div>
                    <p class="font-medium text-lg">Denied</p>
                    <ul class="list-disc list-inside text-sm mt-2 space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                <button type="button" class="ml-auto text-white hover:text-red-200" onclick="this.closest('.pointer-events-auto').remove()">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        @endif
    </div>

    {{-- <div class="grid grid-cols-1 lg:grid-cols-4 gap-6"> --}}
      <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 items-start">

        <!-- Left Sidebar Tabs -->
        <div class="lg:col-span-1">
            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-indigo-500 to-purple-600 text-white">
                    <h2 class="text-lg font-semibold">My Modules</h2>
                </div>
                <div class="divide-y divide-gray-200">
                    {{-- <button onclick="switchTab('active')" class="tab-btn w-full text-left px-6 py-4 hover:bg-indigo-50 transition-colors bg-indigo-100 font-medium border-l-4 border-indigo-600" data-tab="active">
                        Active Modules ({{ $activeEnrollments->count() }})
                    </button> --}}
                    <button
                        onclick="switchTab('active')"
                        class="tab-btn w-full text-left px-6 py-4 transition-all duration-200
                               border-l-4 border-transparent hover:bg-indigo-50"
                        data-tab="active">
                        Active Modules ({{ $activeEnrollments->count() }})
                    </button>
                    
                    <button onclick="switchTab('completed')" class="tab-btn w-full text-left px-6 py-4 hover:bg-indigo-50 transition-colors" data-tab="completed">
                        Completed History ({{ $completedEnrollments->count() }})
                    </button>
                    @if(auth()->user()->role === 'student')
                        <button onclick="switchTab('available')" class="tab-btn w-full text-left px-6 py-4 hover:bg-indigo-50 transition-colors" data-tab="available">
                            Available Modules
                        </button>
                    @endif
                </div>
            </div>
        </div>

        <!-- Right Content Area -->
        {{-- <div class="lg:col-span-3"> --}}
          <div class="lg:col-span-3 lg:min-h-[70vh]">

            <!-- Active Modules Tab -->
            {{-- <div id="tab-active" class="tab-content"> --}}
              <div id="tab-active" class="tab-content space-y-6">

                <h2 class="text-2xl font-bold text-gray-900 mb-6">Active Modules</h2>
                @if($activeEnrollments->isNotEmpty())
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($activeEnrollments as $enrollment)
                            <div class="bg-white shadow-lg rounded-lg overflow-hidden hover:shadow-xl transition-shadow">
                                <div class="px-6 py-4 bg-gradient-to-r from-indigo-500 to-purple-600 text-white">
                                    <h3 class="text-xl font-semibold">{{ $enrollment->module->module }}</h3>
                                    <p class="mt-2 text-sm">Enrolled: {{ $enrollment->enrolled_at->format('d M Y') }}</p>
                                </div>
                                <div class="p-6">
                                    <p class="text-sm text-gray-600 mb-2">
                                        Teacher: {{ $enrollment->module->teacher?->name ?? 'Not assigned' }}
                                    </p>
                                    <div class="flex items-center justify-between">
                                        <span class="px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            In Progress
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="bg-white shadow-lg rounded-lg p-10 text-center">
                        <p class="text-xl text-gray-600">No active modules.</p>
                    </div>
                @endif
            </div>

            <!-- Completed History Tab -->
            <div id="tab-completed" class="tab-content space-y-6">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Completed Modules History</h2>
                @if($completedEnrollments->isNotEmpty())
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
                                @foreach($completedEnrollments as $enrollment)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 font-medium">{{ $enrollment->module->module }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-600">{{ $enrollment->enrolled_at->format('d M Y') }}</td>
                                        <td class="px-6 py-4">
                                            <span class="px-3 py-1 rounded-full text-xs font-medium
                                                {{ $enrollment->pass ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ $enrollment->pass ? 'PASS' : 'FAIL' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-600">{{ $enrollment->completed_at->format('d M Y') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="bg-white shadow-lg rounded-lg p-10 text-center">
                        <p class="text-xl text-gray-600">No completed modules yet.</p>
                    </div>
                @endif
            </div>

            <!-- Available Modules Tab -->
            @if(auth()->user()->role === 'student')
                {{-- <div id="tab-available" class="tab-content hidden"> --}}
                  <div id="tab-available" class="tab-content space-y-6">

                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Available Modules to Enroll</h2>
                    @if($availableModules->isNotEmpty())
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($availableModules as $module)
                                <div class="bg-white shadow-lg rounded-lg overflow-hidden hover:shadow-xl transition-shadow">
                                    <div class="px-6 py-4 bg-gradient-to-r from-blue-500 to-cyan-600 text-white">
                                        <h3 class="text-xl font-semibold">{{ $module->module }}</h3>
                                        <p class="mt-2 text-sm">
                                            Teacher: {{ $module->teacher?->name ?? 'Not assigned' }}
                                        </p>
                                    </div>
                                    <div class="p-6">
                                        <p class="text-sm text-gray-600 mb-4">
                                            Spots left: 
                                            <span class="font-medium">
                                                {{ 10 - $module->enrollments->whereNull('completed_at')->count() }} / 10
                                            </span>
                                        </p>
                                        <form method="POST" action="{{ route('student.enrol', $module->id) }}">
                                            @csrf
                                            <button type="submit"
                                                    class="w-full py-3 rounded-md text-white font-medium transition-colors
                                                           {{ $module->enrollments->whereNull('completed_at')->count() >= 10 
                                                              ? 'bg-gray-400 cursor-not-allowed' 
                                                              : 'bg-indigo-600 hover:bg-indigo-700' }}"
                                                    {{ $module->enrollments->whereNull('completed_at')->count() >= 10 ? 'disabled' : '' }}>
                                                {{ $module->enrollments->whereNull('completed_at')->count() >= 10 ? 'Full' : 'Enroll Now' }}
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="bg-white shadow-lg rounded-lg p-10 text-center">
                            <p class="text-xl text-gray-600">No modules available for enrollment right now.</p>
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>




<script>
    function switchTab(tabId) {
        // Hide all tab contents
        document.querySelectorAll('.tab-content').forEach(content => {
            content.classList.add('hidden');
        });

        // Show selected tab
        const activeTab = document.getElementById('tab-' + tabId);
        activeTab.classList.remove('hidden');

        // Update sidebar buttons
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.classList.remove(
                'bg-indigo-100',
                'font-semibold',
                'border-indigo-600',
                'text-indigo-700'
            );
        });

        const activeBtn = document.querySelector(`[data-tab="${tabId}"]`);
        activeBtn.classList.add(
            'bg-indigo-100',
            'font-semibold',
            'border-indigo-600',
            'text-indigo-700'
        );
    }

    document.addEventListener('DOMContentLoaded', () => {
        switchTab('active');
    });
</script>

@endsection