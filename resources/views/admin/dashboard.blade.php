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
{{-- <div class="flex h-full max-w-7xl mx-auto py-6 sm:px-6 lg:px-8"> --}}
  <div class="flex max-w-7xl mx-auto py-6 sm:px-6 lg:px-8 min-h-[70vh]">
    {{-- Sidebar Tabs --}}
    <div class="w-64 bg-white shadow-lg rounded-l-lg p-4">
        <h2 class="text-xl font-bold mb-6">Admin Panel</h2>
        <ul class="space-y-2" id="sidebar-tabs">
            <li>
                <button data-tab="students" class="tab-btn w-full text-left px-4 py-2 rounded font-medium transition-colors text-gray-700 hover:bg-gray-100">
                    Students
                </button>
            </li>
            <li>
                <button data-tab="modules" class="tab-btn w-full text-left px-4 py-2 rounded font-medium transition-colors text-gray-700 hover:bg-gray-100">
                    Modules
                </button>
            </li>
            <li>
                <button data-tab="teachers" class="tab-btn w-full text-left px-4 py-2 rounded font-medium transition-colors text-gray-700 hover:bg-gray-100">
                    Teachers
                </button>
            </li>
            <li>
                <button data-tab="users" class="tab-btn w-full text-left px-4 py-2 rounded font-medium transition-colors text-gray-700 hover:bg-gray-100">
                    Users & Roles
                </button>
            </li>
        </ul>
    </div>
    {{-- Content Area --}}
    {{-- <div class="flex-1 bg-gray-50 p-6 rounded-r-lg space-y-6 min-h-[70vh]"> --}}
      
    <div class="flex-1 bg-gray-50 rounded-r-lg p-6 min-h-[70vh] flex flex-col">
      <div class="flex-1 space-y-6">
          
            
        
            {{-- Flash Messages --}}
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
        
        
            <!-- Toast Notifications (Top Center) -->
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
        
            {{-- STUDENT TAB --}}
            <div class="tab-content hidden h-full" id="students">
                <h1 class="text-2xl font-bold mb-4">Students</h1>
                {{-- Search & Sort --}}
                <form method="GET" action="{{ route('admin.dashboard') }}" class="flex gap-2 mb-4 flex-wrap">
                    <input type="text" name="student_search" value="{{ request('student_search') }}" placeholder="Search students..." class="flex-1 border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <select name="student_sort" class="border border-gray-300 rounded-md px-4 py-2 text-sm bg-white min-w-32 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="name" {{ request('student_sort')=='name' ? 'selected' : '' }}>Name</option>
                        <option value="email" {{ request('student_sort')=='email' ? 'selected' : '' }}>Email</option>
                        <option value="created_at" {{ request('student_sort')=='created_at' ? 'selected' : '' }}>Created At</option>
                    </select>
                    <select name="student_order" class="border border-gray-300 rounded-md px-4 py-2 text-sm bg-white min-w-32 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="asc" {{ request('student_order')=='asc' ? 'selected' : '' }}>Asc</option>
                        <option value="desc" {{ request('student_order')=='desc' ? 'selected' : '' }}>Desc</option>
                    </select>
                    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 transition-colors">Filter</button>
                </form>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @forelse($students as $student)
                        <div class="bg-white shadow-lg rounded-lg p-4 flex flex-col justify-between hover:shadow-xl transition-shadow">
                            <div>
                                <h2 class="font-semibold text-lg">{{ $student->name }}</h2>
                                <p class="text-sm text-gray-500 truncate">{{ $student->email }} • Role: {{ $student->userRole->role }}</p>
                            </div>
                            {{-- Collapsible Enrollments --}}
                            <div class="mt-2">
                                <button class="toggle-students text-sm text-indigo-600 hover:underline" data-target="student-enroll-{{ $student->id }}">
                                    {{ $student->enrollments->count() }} Modules Enrolled
                                </button>
                                <ul id="student-enroll-{{ $student->id }}" class="mt-2 list-disc pl-5 space-y-1 hidden">
                                    @forelse($student->enrollments as $enrollment)
                                        <li class="flex justify-between items-center">
                                            <span>{{ $enrollment->module->module }}</span>
                                            <form method="POST" action="{{ route('admin.enrollments.remove', $enrollment->id) }}">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium" onclick="return confirm('Are you sure you want to remove this student from the module?');">Remove</button>
                                            </form>
                                        </li>
                                    @empty
                                        <li class="text-gray-500 text-sm">No enrollments</li>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-gray-500 col-span-full">No students found</div>
                    @endforelse
                </div>
                {{-- Pagination --}}
                <div class="mt-6">
                    {{ $students->links() }}
                </div>
            </div>
        
            {{-- MODULES TAB --}}
            <div class="tab-content hidden h-full" id="modules">
                <h1 class="text-2xl font-bold mb-4">Modules</h1>
                {{-- Search & Sort --}}
                <form method="GET" action="{{ route('admin.dashboard') }}" class="flex gap-2 mb-4 flex-wrap">
                    <input type="text" name="module_search" value="{{ request('module_search') }}" placeholder="Search modules..." class="flex-1 border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <select name="module_sort" class="border border-gray-300 rounded-md px-8 py-2 text-sm bg-white min-w-32 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="created_at" {{ request('module_sort')=='created_at' ? 'selected' : '' }}>Created At</option>
                        <option value="module" {{ request('module_sort')=='module' ? 'selected' : '' }}>Module Name</option>
                    </select>
                    <select name="module_order" class="border border-gray-300 rounded-md px-4 py-2 text-sm bg-white min-w-32 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="asc" {{ request('module_order')=='asc' ? 'selected' : '' }}>Asc</option>
                        <option value="desc" {{ request('module_order')=='desc' ? 'selected' : '' }}>Desc</option>
                    </select>
                    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 transition-colors">Filter</button>
                </form>
                {{-- Add Module --}}
                <div class="bg-white shadow rounded-lg p-4 mb-6">
                    <form method="POST" action="{{ route('admin.modules.store') }}" class="flex gap-2 flex-wrap">
                        @csrf
                        <input type="text" name="module" placeholder="Module name" required class="flex-1 border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 transition-colors">Add Module</button>
                    </form>
                </div>
                {{-- Modules List --}}
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($modules as $module)
                        <div class="bg-white shadow-lg rounded-lg p-4 flex flex-col justify-between hover:shadow-xl transition-shadow">
                            <div>
                                <h2 class="font-semibold text-lg">{{ $module->module }}</h2>
                                <p class="text-sm text-gray-500">
                                    Teacher: {{ $module->teacher?->name ?? 'None' }} <br>
                                    Students: {{ $module->enrollments->count() }}
                                </p>
                                <span class="inline-block px-2 py-1 rounded text-sm font-medium {{ $module->active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $module->active ? 'Available' : 'Unavailable' }}
                                </span>
                            </div>
                            <div class="mt-4 flex flex-wrap gap-2">
                                {{-- Toggle Active --}}
                                <form method="POST" action="{{ route('admin.modules.toggle', $module) }}">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="px-3 py-1 rounded text-sm font-medium {{ $module->active ? 'bg-yellow-100 text-yellow-800 hover:bg-yellow-200' : 'bg-green-100 text-green-800 hover:bg-green-200' }}">
                                        {{ $module->active ? 'Make Unavailable' : 'Make Available' }}
                                    </button>
                                </form>
                                
                                {{-- Assign Teacher --}}
                                <form method="POST" action="{{ route('admin.modules.assign', $module) }}" class="flex gap-2">
                                    @csrf
                                    {{-- <select name="teacher_id" class="border border-gray-300 rounded px-6 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                        <option value="">None</option>
                                        @foreach($teachers as $teacher)
                                            <option value="{{ $teacher->id }}" {{ $module->teacher_id == $teacher->id ? 'selected' : '' }}>{{ $teacher->name }}</option>
                                        @endforeach
                                    </select> --}}
                                    <select name="teacher_id" class="border border-gray-300 rounded px-6 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                        <option value="">None</option>
                                        @foreach($allTeachers as $teacher)
                                            <option value="{{ $teacher->id }}" {{ $module->teacher_id == $teacher->id ? 'selected' : '' }}>{{ $teacher->name }}</option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="bg-indigo-600 text-white px-3 py-1 rounded hover:bg-indigo-700 transition-colors text-sm">Assign</button>
                                </form>
        
                            </div>
        
                           
                           
                            {{-- Collapsible Students --}}
                            <div class="mt-2">
                                <button class="toggle-students text-sm text-indigo-600 hover:underline" data-target="students-{{ $module->id }}">
                                    {{ $module->enrollments->count() }} Students Enrolled
                                </button>
                                <ul id="students-{{ $module->id }}" class="mt-2 list-disc pl-5 space-y-1 hidden">
                                    @foreach($module->enrollments as $enrollment)
                                        <li class="flex justify-between items-center">
                                            <span>{{ $enrollment->student->name }} ({{ $enrollment->student->email }})</span>
                                            <form method="POST" action="{{ route('admin.enrollments.remove', $enrollment->id) }}">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium" onclick="return confirm('Are you sure you want to remove this student from the module?');">Remove</button>
                                            </form>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-center text-gray-500">No modules found</div>
                    @endforelse
                </div>
                {{-- Pagination --}}
                <div class="mt-6">
                    {{ $modules->links() }}
                </div>
            </div>
            
            {{-- TEACHER TAB --}}
            <div class="tab-content hidden h-full" id="teachers">
                <h1 class="text-2xl font-bold mb-4">Teachers</h1>
                {{-- Search & Sort --}}
                <form method="GET" action="{{ route('admin.dashboard') }}" class="flex gap-2 mb-4 flex-wrap">
                    <input type="text" name="teacher_search" value="{{ request('teacher_search') }}" placeholder="Search teachers..." class="flex-1 border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <select name="teacher_sort" class="border border-gray-300 rounded-md px-4 py-2 text-sm bg-white min-w-32 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="name" {{ request('teacher_sort')=='name' ? 'selected' : '' }}>Name</option>
                        <option value="email" {{ request('teacher_sort')=='email' ? 'selected' : '' }}>Email</option>
                        <option value="created_at" {{ request('teacher_sort')=='created_at' ? 'selected' : '' }}>Created At</option>
                    </select>
                    <select name="teacher_order" class="border border-gray-300 rounded-md px-4 py-2 text-sm bg-white min-w-32 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="asc" {{ request('teacher_order')=='asc' ? 'selected' : '' }}>Asc</option>
                        <option value="desc" {{ request('teacher_order')=='desc' ? 'selected' : '' }}>Desc</option>
                    </select>
                    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 transition-colors">Filter</button>
                </form>
                {{-- Add Teacher --}}
                <div class="bg-white shadow-lg rounded-lg p-4 mb-6 hover:shadow-xl transition-shadow">
                    <form method="POST" action="{{ route('admin.teachers.store') }}" class="space-y-2">
                        @csrf
                        <input type="text" name="name" placeholder="Teacher Name" required class="w-full border px-4 py-2 rounded focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <input type="email" name="email" placeholder="Teacher Email" required class="w-full border px-4 py-2 rounded focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <input type="password" name="password" placeholder="Password" required class="w-full border px-4 py-2 rounded focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <input type="password" name="password_confirmation" placeholder="Confirm Password" required class="w-full border px-4 py-2 rounded focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded hover:bg-indigo-700 transition-colors">Create Teacher</button>
                    </form>
                </div>
                {{-- Teachers List --}}
                <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                    <div class="divide-y divide-gray-200">
                        {{-- @forelse($teachers as $teacher) --}}
                        @forelse($paginatedTeachers as $teacher)
                            <div class="px-4 py-3 flex justify-between items-center">
                                <div>
                                    <p class="font-medium">{{ $teacher->name }}</p>
                                    <p class="text-sm text-gray-500">{{ $teacher->email }}</p>
                                </div>
                                <form method="POST" action="{{ route('admin.teachers.destroy', $teacher->id) }}">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium" onclick="return confirm('Are you sure you want to remove this teacher?');">Remove</button>
                                </form>
                            </div>
                        {{-- @empty
                            <div class="px-6 py-8 text-center text-gray-500">No teachers found</div>
                        @endforelse --}}
                        @empty
                            <div class="px-6 py-8 text-center text-gray-500">No teachers found</div>
                        @endforelse
                    </div>
                    <div class="mt-4 px-4">
                        {{ $paginatedTeachers->links() }}
                    </div>
                </div>
            </div>
        
            {{-- USERS TAB --}}
            
            <div class="tab-content hidden h-full" id="users">
                <h1 class="text-2xl font-bold mb-4">Users & Roles</h1>
                {{-- Search & Sort --}}
                <form method="GET" action="{{ route('admin.dashboard') }}" class="flex gap-2 mb-4 flex-wrap">
                    <input type="text" name="user_search" value="{{ request('user_search') }}" placeholder="Search users..." class="flex-1 border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <select name="user_sort" class="border border-gray-300 rounded-md px-4 py-2 text-sm bg-white min-w-32 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="name" {{ request('user_sort')=='name' ? 'selected' : '' }}>Name</option>
                        <option value="email" {{ request('user_sort')=='email' ? 'selected' : '' }}>Email</option>
                        <option value="created_at" {{ request('user_sort')=='created_at' ? 'selected' : '' }}>Created At</option>
                    </select>
                    <select name="user_order" class="border border-gray-300 rounded-md px-4 py-2 text-sm bg-white min-w-32 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="asc" {{ request('user_order')=='asc' ? 'selected' : '' }}>Asc</option>
                        <option value="desc" {{ request('user_order')=='desc' ? 'selected' : '' }}>Desc</option>
                    </select>
                    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 transition-colors">Filter</button>
                </form>
                {{-- Users List --}}
                <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                    <div class="divide-y divide-gray-200">
                        @forelse($users as $user)
                            <div class="px-4 py-3 flex justify-between items-center">
                                <div>
                                    <p class="font-medium">{{ $user->name }}</p>
                                    <p class="text-sm text-gray-500">{{ $user->email }} • Role: {{ $user->userRole->role }}</p>
                                </div>
                                {{-- Change Role --}}
                                <form method="POST" action="{{ route('admin.users.change-role', $user->id) }}" class="flex gap-2">
                                    @csrf
                                    <select name="role" class="border border-gray-300 rounded-md px-4 py-2 text-sm bg-white min-w-40 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                        <option value="admin" {{ $user->userRole->role=='admin' ? 'selected' : '' }}>Admin</option>
                                        <option value="teacher" {{ $user->userRole->role=='teacher' ? 'selected' : '' }}>Teacher</option>
                                        <option value="student" {{ $user->userRole->role=='student' ? 'selected' : '' }}>Student</option>
                                        <option value="old_student" {{ $user->userRole->role=='old_student' ? 'selected' : '' }}>Old Student</option>
                                    </select>
                                    <button type="submit" class="bg-indigo-600 text-white px-3 py-1 rounded hover:bg-indigo-700 transition-colors text-sm">Update</button>
                                </form>
                            </div>
                        @empty
                            <div class="px-6 py-8 text-center text-gray-500">No users found</div>
                        @endforelse
                    </div>
                    <div class="mt-4 px-4">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        

      </div>
    </div>
     
        

</div>

{{-- Tab & Collapse JS --}}
{{-- <script>
    document.addEventListener('DOMContentLoaded', () => {
        // Tab switching
        const tabs = document.querySelectorAll('.tab-btn');
        const contents = document.querySelectorAll('.tab-content');
        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                contents.forEach(c => c.classList.add('hidden'));
                tabs.forEach(t => t.classList.remove('bg-indigo-500', 'text-white'));
                document.getElementById(tab.dataset.tab).classList.remove('hidden');
                tab.classList.add('bg-indigo-500', 'text-white');
                localStorage.setItem('adminActiveTab', tab.dataset.tab);
            });
        });
        // Restore active tab
        const activeTab = localStorage.getItem('adminActiveTab') || 'students';
        const activeBtn = document.querySelector(`[data-tab="${activeTab}"]`);
        if (activeBtn) {
            activeBtn.click();
        } else {
            tabs[0].click();
        }
        // Collapse toggle
        const toggles = document.querySelectorAll('.toggle-students');
        toggles.forEach(btn => {
            btn.addEventListener('click', () => {
                const target = document.getElementById(btn.dataset.target);
                target.classList.toggle('hidden');
            });
        });
    });
</script> --}}

{{-- Tab & Collapse JS --}}
{{-- <script>
    document.addEventListener('DOMContentLoaded', () => {
        const tabs = document.querySelectorAll('.tab-btn');
        const contents = document.querySelectorAll('.tab-content');

        // Function to activate a tab
        const activateTab = (tabId) => {
            // Hide all content
            contents.forEach(c => c.classList.add('hidden'));
            // Remove active style from all buttons
            tabs.forEach(t => t.classList.remove('bg-indigo-500', 'text-white'));
            // Show selected content
            document.getElementById(tabId).classList.remove('hidden');
            // Highlight selected button
            document.querySelector(`[data-tab="${tabId}"]`).classList.add('bg-indigo-500', 'text-white');

            // Save to localStorage
            localStorage.setItem('adminActiveTab', tabId);

            // === CLEAN URL: Remove all pagination parameters when switching tabs ===
            const url = new URL(window.location);
            ['module_page', 'student_page', 'teacher_page', 'user_page'].forEach(param => {
                url.searchParams.delete(param);
            });
            window.history.replaceState({}, '', url);
        };

        // Attach click event to each tab
        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                activateTab(tab.dataset.tab);
            });
        });

        // Restore last active tab on page load
        let activeTab = localStorage.getItem('adminActiveTab') || 'students';

        // If current URL has a page parameter, prioritize the corresponding tab
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('module_page')) activeTab = 'modules';
        else if (urlParams.has('student_page')) activeTab = 'students';
        else if (urlParams.has('teacher_page')) activeTab = 'teachers';
        else if (urlParams.has('user_page')) activeTab = 'users';

        // Activate the correct tab
        const activeBtn = document.querySelector(`[data-tab="${activeTab}"]`);
        if (activeBtn) {
            activateTab(activeTab);
        } else {
            tabs[0].click(); // fallback
        }

        // Collapse toggle for enrolled students
        const toggles = document.querySelectorAll('.toggle-students');
        toggles.forEach(btn => {
            btn.addEventListener('click', () => {
                const target = document.getElementById(btn.dataset.target);
                if (target) {
                    target.classList.toggle('hidden');
                    // Optional: change button text
                    btn.textContent = target.classList.contains('hidden')
                        ? `${btn.dataset.count || ''} Students Enrolled`
                        : 'Hide Students';
                }
            });
        });
    });
</script> --}}


{{-- Tab & Collapse JS --}}
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const tabs = document.querySelectorAll('.tab-btn');
        const contents = document.querySelectorAll('.tab-content');

        // Mapping between tab ID and its pagination parameter name
        const tabPageMap = {
            'students': 'student_page',
            'modules': 'module_page',
            'teachers': 'teacher_page',
            'users': 'user_page'
        };

        // Function to activate a tab and update URL accordingly
        const activateTab = (tabId) => {
            // Hide all content and deactivate buttons
            contents.forEach(c => c.classList.add('hidden'));
            tabs.forEach(t => t.classList.remove('bg-indigo-500', 'text-white'));

            // Show selected tab
            document.getElementById(tabId).classList.remove('hidden');
            const activeButton = document.querySelector(`[data-tab="${tabId}"]`);
            activeButton.classList.add('bg-indigo-500', 'text-black');

            // Save to localStorage
            localStorage.setItem('adminActiveTab', tabId);

            // === Update URL to reflect current tab's page ===
            const url = new URL(window.location);
            const pageParam = tabPageMap[tabId];

            // Remove all other tab page parameters
            Object.values(tabPageMap).forEach(param => {
                url.searchParams.delete(param);
            });

            // If the current tab has a page number in URL, keep it; otherwise remove it
            const currentPage = url.searchParams.get(pageParam);
            if (!currentPage || currentPage === '1') {
                url.searchParams.delete(pageParam); // Clean ?page=1
            }

            // Update URL without reload
            window.history.replaceState({}, '', url);
        };

        // Click handler for tabs
        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                activateTab(tab.dataset.tab);
            });
        });

        // === On page load: Determine which tab should be active ===
        const urlParams = new URLSearchParams(window.location.search);
        let activeTab = null;

        // Check if any tab-specific page parameter exists → open that tab
        if (urlParams.has('module_page')) activeTab = 'modules';
        else if (urlParams.has('student_page')) activeTab = 'students';
        else if (urlParams.has('teacher_page')) activeTab = 'teachers';
        else if (urlParams.has('user_page')) activeTab = 'users';

        // Fallback to localStorage or default
        if (!activeTab) {
            activeTab = localStorage.getItem('adminActiveTab') || 'students';
        }

        // Activate the correct tab
        const activeBtn = document.querySelector(`[data-tab="${activeTab}"]`);
        if (activeBtn) {
            activateTab(activeTab);
        } else {
            tabs[0].click(); // fallback to first tab
        }

        // === Collapse toggle for student/module enrollments ===
        const toggles = document.querySelectorAll('.toggle-students');
        toggles.forEach(btn => {
            btn.addEventListener('click', () => {
                const target = document.getElementById(btn.dataset.target);
                if (target) {
                    target.classList.toggle('hidden');
                }
            });
        });
    });
</script>
@endsection