<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- <title>EduAdmin - Digital Educational Admininstrative Site</title> --}}
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css'])
</head>
<body class="bg-gray-50 text-gray-800">

    {{-- Navbar --}}
    {{-- <nav class="sticky top-0 z-50 bg-white/90 backdrop-blur border-b border-gray-200"> --}}
      <nav class="sticky top-0 z-50 bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex justify-between items-center h-16">
    
                 {{-- Logo --}}
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-indigo-600 text-white rounded-xl flex items-center justify-center font-bold text-xl">
                        EAS
                    </div>
                    <div>
                        <span class="text-xl font-extrabold text-gray-300">EduAdmin</span>
                        <p class="text-xs text-gray-500 leading-none">Educational Administrative Site</p>
                    </div>
                </div>
    
                {{-- Auth Buttons --}}
                <div class="flex items-center space-x-3">
                    @auth
                        <a href="{{ url('/dashboard') }}"
                           class="px-4 py-2 rounded-lg bg-indigo-600 text-white text-sm font-semibold hover:bg-indigo-700 transition shadow">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                           class="px-4 py-2 rounded-lg text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 transition">
                            Login
                        </a>
                        <a href="{{ route('register') }}"
                           class="px-4 py-2 rounded-lg bg-indigo-600 text-white text-sm font-semibold hover:bg-indigo-700 transition shadow">
                            Register
                        </a>
                    @endauth
                </div>
    
            </div>
        </div>
    </nav>
    

    {{-- Hero Section --}}
    <section class="bg-indigo-700 text-white py-24 relative overflow-hidden">
        <div class="max-w-6xl mx-auto px-6 grid grid-cols-1 md:grid-cols-2 gap-8 items-center relative z-10">
            {{-- Left Side Content --}}
            <div class="flex flex-col justify-center h-full relative z-10">
                <h1 class="text-5xl font-bold leading-tight mb-4">
                    Empower Your Education Management
                </h1>
                <p class="text-xl mb-6">
                    A complete educational administrative solution built for administrators, teachers, and students. Manage modules, users, records, and performance with ease.
                </p>
    
                <div class="space-x-4">
                    <a href="{{ route('register') }}" class="bg-white text-indigo-700 font-semibold px-6 py-3 rounded-lg shadow hover:bg-gray-100 transition">Get Started</a>
                    <a href="{{ route('login') }}" class="bg-indigo-900 text-white font-semibold px-6 py-3 rounded-lg shadow hover:bg-indigo-800 transition">Login</a>
                </div>
            </div>

            {{-- Watermark: Right side on large screens --}}
            <div class="absolute z-0 right-0 top-1/2 -translate-y-1/2 text-white/5 text-[220px] font-extrabold select-none hidden md:block pointer-events-none">
                EAS
            </div>
            
            {{-- Watermark: Center behind text on small screens --}}
            <div class="absolute inset-0 flex items-center justify-center z-0 text-white/5 text-[180px] font-extrabold select-none md:hidden pointer-events-none">
                EAS
            </div>
        </div>     
    </section>


    {{-- Feature Highlights --}}
    <section class="py-16">
        <div class="max-w-6xl mx-auto px-6 text-center">
            <h2 class="text-4xl font-bold text-gray-800 mb-10">Designed For Every Role</h2>

            <div class="grid md:grid-cols-3 gap-8">
                {{-- Admin --}}
                <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-xl transition">
                    <h3 class="text-2xl font-semibold text-indigo-600 mb-3">Admin Control</h3>
                    <p class="text-gray-600">
                        Add modules, manage teachers, toggle availability, and configure users with full control and audit trails.
                    </p>
                </div>

                {{-- Teacher --}}
                <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-xl transition">
                    <h3 class="text-2xl font-semibold text-indigo-600 mb-3">Teacher Dashboard</h3>
                    <p class="text-gray-600">
                        View assigned modules and students, record progress, and create meaningful insights into learning outcomes.
                    </p>
                </div>

                {{-- Student --}}
                <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-xl transition">
                    <h3 class="text-2xl font-semibold text-indigo-600 mb-3">Student Experience</h3>
                    <p class="text-gray-600">
                        Enroll in modules, view pass/fail history and engage with academic progress seamlessly.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- Benefits / Stats --}}
    <section class="bg-indigo-50 py-16">
        <div class="max-w-5xl mx-auto text-center px-6">
            <h2 class="text-3xl font-bold text-gray-800 mb-6">Why EduAdmin?</h2>
            <div class="grid md:grid-cols-3 gap-8 text-center">
                <div>
                    <h3 class="text-4xl font-extrabold text-indigo-600">100%</h3>
                    <p class="text-gray-600 mt-2">Uptime & Reliability</p>
                </div>
                <div>
                    <h3 class="text-4xl font-extrabold text-indigo-600">500+</h3>
                    <p class="text-gray-600 mt-2">Modules Managed</p>
                </div>
                <div>
                    <h3 class="text-4xl font-extrabold text-indigo-600">10k+</h3>
                    <p class="text-gray-600 mt-2">Active Users</p>
                </div>
            </div>
        </div>
    </section>


    {{-- Call To Action --}}
    <section class="py-16 bg-gradient-to-r from-indigo-700 via-indigo-600 to-indigo-500 text-white text-center relative overflow-hidden">
        {{-- Background decorative shapes --}}
        <div class="absolute -top-20 -left-20 w-72 h-72 bg-white/5 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute -bottom-20 -right-20 w-72 h-72 bg-white/5 rounded-full blur-3xl animate-pulse delay-2000"></div>
    
        <div class="relative z-10 max-w-3xl mx-auto px-6">
            <h2 class="text-4xl md:text-5xl font-extrabold mb-4">
                Ready To Transform Education?
            </h2>
            <p class="text-lg md:text-xl mb-8 text-white/80">
                Join hundreds of institutions that are modernizing education management with ease and efficiency.
            </p>
            <div class="flex flex-col md:flex-row justify-center gap-4">
                <a href="{{ route('register') }}" 
                   class="bg-white text-indigo-700 font-semibold px-8 py-4 rounded-full shadow-lg hover:shadow-xl hover:scale-105 transition transform">
                   Create Your Account
                </a>
                <a href="#learn-more" 
                   class="border border-white text-white font-semibold px-8 py-4 rounded-full hover:bg-white hover:text-indigo-700 transition transform hover:scale-105">
                   Learn More
                </a>
            </div>
        </div>
    </section>
    
    {{-- footer --}}
    <footer class="bg-gray-900 text-gray-300">
        <div class="max-w-7xl mx-auto px-6 py-16">
    
            {{-- Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-10 text-center md:text-left">
    
                {{-- Brand --}}
                <div class="flex flex-col items-center md:items-start">
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-10 h-10 bg-indigo-600 text-white rounded-xl flex items-center justify-center font-bold text-xl">
                            EAS
                        </div>
                        {{-- <span class="text-xl font-bold text-white">EduAdmin</span> --}}
                        <div>
                            <span class="text-xl font-extrabold text-gray-300">EduAdmin</span>
                            <p class="text-xs text-gray-500 leading-none">Educational Administrative Site</p>
                        </div>
                    </div>
                    <p class="text-sm text-gray-400 leading-relaxed max-w-sm">
                        A modern educational administrative platform designed to manage modules,
                        teachers, students, and academic outcomes efficiently.
                    </p>
                </div>
    
                {{-- Platform --}}
                <div>
                    <h4 class="text-white font-semibold mb-4">Platform</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-indigo-400 transition">Admin Panel</a></li>
                        <li><a href="#" class="hover:text-indigo-400 transition">Teacher Dashboard</a></li>
                        <li><a href="#" class="hover:text-indigo-400 transition">Student Portal</a></li>
                        <li><a href="#" class="hover:text-indigo-400 transition">Module Management</a></li>
                    </ul>
                </div>
                
    
                {{-- Contact Information (REPLACED RESOURCES) --}}
                <div>
                    <h4 class="text-white font-semibold mb-4">Contact Us</h4>
                    <ul class="space-y-3 text-sm">
                        <li class="flex items-center justify-center md:justify-start gap-2">
                            📧 <span>support@eduadmin.edu</span>
                        </li>
                        <li class="flex items-center justify-center md:justify-start gap-2">
                            📞 <span>+977 9819965626</span>
                        </li>
                        <li class="flex items-center justify-center md:justify-start gap-2">
                            📍 <span>Kathmandu, Nepal</span>
                        </li>
                        <li class="flex items-center justify-center md:justify-start gap-2">
                            🕒 <span>Mon – Fri, 9AM – 5PM</span>
                        </li>
                    </ul>
                </div>
    
                {{-- Legal --}}
                <div>
                    <h4 class="text-white font-semibold mb-4">Legal</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-indigo-400 transition">Privacy Policy</a></li>
                        <li><a href="#" class="hover:text-indigo-400 transition">Terms of Service</a></li>
                        <li><a href="#" class="hover:text-indigo-400 transition">Data Protection</a></li>
                    </ul>
                </div>
    
            </div>
    
            {{-- Divider --}}
            <div class="border-t border-gray-700 mt-12 pt-6 text-center text-sm text-gray-400">
                © {{ date('Y') }} EduAdmin. All rights reserved.
                <p class="mt-1">
                    A Modern Digital Advanced Educational Administrative Platform
                </p>
            </div>
    
        </div>
    </footer>
    
  
</body>
</html>
