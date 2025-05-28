<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Klinik Sehat') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        html {
            scroll-behavior: smooth;
        }
        .hero-overlay {
            background-color: rgba(0, 0, 0, 0.5);
        }
        .navbar-fixed {
            @apply fixed top-0 left-0 w-full bg-white shadow-md transition-all duration-300 ease-in-out z-50;
        }
        .navbar-transparent {
            @apply fixed top-0 left-0 w-full bg-transparent transition-all duration-300 ease-in-out z-50;
        }
        .fade-in {
            animation: fadeIn 1s ease-in;
        }
        @keyframes fadeIn {
            0% { opacity: 0; }
            100% { opacity: 1; }
        }
        .slide-up {
            animation: slideUp 0.8s ease-out;
        }
        @keyframes slideUp {
            0% { 
                transform: translateY(50px);
                opacity: 0;
            }
            100% { 
                transform: translateY(0);
                opacity: 1;
            }
        }
        .pulse-btn {
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(59, 130, 246, 0.7);
            }
            70% {
                box-shadow: 0 0 0 10px rgba(59, 130, 246, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(59, 130, 246, 0);
            }
        }
    </style>
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-50">
        <!-- Navbar -->
        <nav id="navbar" class="navbar-transparent">
            <div class="container mx-auto px-4 py-4">
                <div class="flex justify-between items-center">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-blue-600 mr-2"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"></path></svg>
                        <a href="{{ url('/') }}" class="text-2xl font-bold text-black transition-colors duration-300" id="brand-text">Klinik Sehat</a>
                    </div>
                    <div class="hidden md:flex items-center">
                        <a href="#beranda" class="text-black hover:text-blue-200 transition-colors duration-300 mr-6" id="nav-link-1">Beranda</a>
                        <a href="#layanan" class="text-black hover:text-blue-200 transition-colors duration-300 mr-6" id="nav-link-2">Layanan</a>
                        <a href="#dokter" class="text-black hover:text-blue-200 transition-colors duration-300 mr-6" id="nav-link-3">Dokter</a>
                        <a href="#kontak" class="text-black hover:text-blue-200 transition-colors duration-300 mr-6" id="nav-link-4">Kontak</a>
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-black font-medium rounded-lg transition-all transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">Dashboard</a>
                            @else
                                <a href="{{ route('login') }}" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-black font-medium rounded-lg transition-all transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">Login</a>
                                <a href="{{ route('register') }}" class="ml-2 px-5 py-2.5 bg-white border border-black text-black font-medium rounded-lg transition-all transform hover:scale-105 hover:bg-black hover:text-white focus:outline-none focus:ring-2 focus:ring-black focus:ring-opacity-50">Register</a>
                            @endauth
                        @endif
                    </div>
                    <div class="md:hidden">
                        <button id="mobile-menu-button" class="text-black focus:outline-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Mobile Menu -->
                <div id="mobile-menu" class="hidden mt-4 bg-white rounded-lg shadow-lg p-4 md:hidden">
                    <div class="flex flex-col space-y-3">
                        <a href="#beranda" class="text-gray-800 hover:text-blue-600 transition-colors duration-300">Beranda</a>
                        <a href="#layanan" class="text-gray-800 hover:text-blue-600 transition-colors duration-300">Layanan</a>
                        <a href="#dokter" class="text-gray-800 hover:text-blue-600 transition-colors duration-300">Dokter</a>
                        <a href="#kontak" class="text-gray-800 hover:text-blue-600 transition-colors duration-300">Kontak</a>
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}" class="px-4 py-2 bg-blue-600 text-white font-medium rounded-lg text-center">Dashboard</a>
                            @else
                                <a href="{{ route('login') }}" class="px-4 py-2 bg-blue-600 text-white font-medium rounded-lg text-center">Login</a>
                            @endauth
                        @endif
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <section id="beranda" class="relative h-screen">
            <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('https://images.pexels.com/photos/3846005/pexels-photo-3846005.jpeg?auto=compress&cs=tinysrgb&w=1920');">
                <div class="absolute inset-0 hero-overlay"></div>
            </div>
            <div class="relative container mx-auto px-4 h-full flex items-center">
                <div class="max-w-xl fade-in">
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-6 leading-tight">Kesehatan Anda, Prioritas Kami</h1>
                    <p class="text-lg md:text-xl text-gray-100 mb-8">Pelayanan kesehatan terbaik untuk Anda dan keluarga dengan dokter terpercaya dan fasilitas modern.</p>
                    <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
                        <a href="#layanan" class="px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg text-center transition-all transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 pulse-btn">Lihat Layanan</a>
                        <a href="#kontak" class="px-8 py-3 bg-transparent hover:bg-white/10 border-2 border-white text-white font-medium rounded-lg text-center transition-all transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-white focus:ring-opacity-50">Hubungi Kami</a>
                    </div>
                </div>
            </div>
            <div class="absolute bottom-10 left-1/2 transform -translate-x-1/2 animate-bounce">
                <a href="#layanan" class="text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"></path></svg>
                </a>
            </div>
        </section>

        <!-- Layanan Section -->
        <section id="layanan" class="py-16 md:py-24 bg-white">
            <div class="container mx-auto px-4">
                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Layanan Unggulan</h2>
                    <p class="text-lg text-gray-600 max-w-2xl mx-auto">Kami menyediakan berbagai layanan kesehatan berkualitas untuk memenuhi kebutuhan Anda dan keluarga.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300 overflow-hidden slide-up" style="animation-delay: 0.1s">
                        <div class="p-6">
                            <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mb-6">
                                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-blue-600"><path d="M3 9h18v10a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V9Z"></path><path d="m3 9 2.45-4.9A2 2 0 0 1 7.24 3h9.52a2 2 0 0 1 1.8 1.1L21 9"></path><path d="M12 3v6"></path></svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-3">Pemeriksaan Umum</h3>
                            <p class="text-gray-600 mb-4">Konsultasi dan pemeriksaan kesehatan umum oleh dokter berpengalaman dengan pendekatan yang ramah dan profesional.</p>
                            <a href="#" class="text-blue-600 hover:text-blue-800 font-medium inline-flex items-center transition-colors duration-300">
                                Selengkapnya
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="ml-1"><path d="m9 18 6-6-6-6"></path></svg>
                            </a>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300 overflow-hidden slide-up" style="animation-delay: 0.2s">
                        <div class="p-6">
                            <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mb-6">
                                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-blue-600"><path d="M17 18a2 2 0 0 1-2 2H9a2 2 0 0 1-2-2V9a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v9Z"></path><path d="m17 9-6 6"></path><path d="M11 9h6"></path></svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-3">Kesehatan Gigi</h3>
                            <p class="text-gray-600 mb-4">Perawatan gigi dan mulut komprehensif, dari pembersihan karang gigi hingga perawatan saluran akar dan estetika gigi.</p>
                            <a href="#" class="text-blue-600 hover:text-blue-800 font-medium inline-flex items-center transition-colors duration-300">
                                Selengkapnya
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="ml-1"><path d="m9 18 6-6-6-6"></path></svg>
                            </a>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300 overflow-hidden slide-up" style="animation-delay: 0.3s">
                        <div class="p-6">
                            <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mb-6">
                                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-blue-600"><path d="M20 7h-3a2 2 0 0 1-2-2V2"></path><path d="M9 18a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h7l4 4v10a2 2 0 0 1-2 2Z"></path><path d="M3 7.6v12.8A1.6 1.6 0 0 0 4.6 22h14.8a1.6 1.6 0 0 0 1.6-1.6V7.6"></path></svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-3">Kesehatan Ibu & Anak</h3>
                            <p class="text-gray-600 mb-4">Layanan komprehensif untuk kesehatan ibu hamil dan tumbuh kembang anak dengan pendekatan yang holistik.</p>
                            <a href="#" class="text-blue-600 hover:text-blue-800 font-medium inline-flex items-center transition-colors duration-300">
                                Selengkapnya
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="ml-1"><path d="m9 18 6-6-6-6"></path></svg>
                            </a>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300 overflow-hidden slide-up" style="animation-delay: 0.4s">
                        <div class="p-6">
                            <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mb-6">
                                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-blue-600"><path d="M4.8 2.3A.3.3 0 1 0 5 2H4a2 2 0 0 0-2 2v5a6 6 0 0 0 6 6v0a6 6 0 0 0 6-6V4a2 2 0 0 0-2-2h-1a.2.2 0 1 0 .3.3"></path><path d="M8 15v1a6 6 0 0 0 6 6v0a6 6 0 0 0 6-6v-4"></path><circle cx="20" cy="10" r="2"></circle></svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-3">Laboratorium</h3>
                            <p class="text-gray-600 mb-4">Fasilitas laboratorium modern untuk pemeriksaan darah, urin, dan tes diagnostik lainnya dengan hasil yang cepat dan akurat.</p>
                            <a href="#" class="text-blue-600 hover:text-blue-800 font-medium inline-flex items-center transition-colors duration-300">
                                Selengkapnya
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="ml-1"><path d="m9 18 6-6-6-6"></path></svg>
                            </a>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300 overflow-hidden slide-up" style="animation-delay: 0.5s">
                        <div class="p-6">
                            <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mb-6">
                                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-blue-600"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"></path></svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-3">Kardiologi</h3>
                            <p class="text-gray-600 mb-4">Layanan kesehatan jantung dengan dokter spesialis kardiologi berpengalaman dan peralatan diagnostik terkini.</p>
                            <a href="#" class="text-blue-600 hover:text-blue-800 font-medium inline-flex items-center transition-colors duration-300">
                                Selengkapnya
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="ml-1"><path d="m9 18 6-6-6-6"></path></svg>
                            </a>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300 overflow-hidden slide-up" style="animation-delay: 0.6s">
                        <div class="p-6">
                            <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mb-6">
                                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-blue-600"><rect width="20" height="14" x="2" y="3" rx="2"></rect><line x1="8" x2="16" y1="21" y2="21"></line><line x1="12" x2="12" y1="17" y2="21"></line></svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-3">Telemedicine</h3>
                            <p class="text-gray-600 mb-4">Konsultasi kesehatan online dengan dokter kami melalui video call untuk kenyamanan Anda tanpa perlu datang ke klinik.</p>
                            <a href="#" class="text-blue-600 hover:text-blue-800 font-medium inline-flex items-center transition-colors duration-300">
                                Selengkapnya
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="ml-1"><path d="m9 18 6-6-6-6"></path></svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Dokter Section -->
        <section id="dokter" class="py-16 md:py-24 bg-gray-50">
            <div class="container mx-auto px-4">
                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Tim Dokter Kami</h2>
                    <p class="text-lg text-gray-600 max-w-2xl mx-auto">Dokter berpengalaman dan profesional yang siap memberikan perawatan terbaik untuk Anda dan keluarga.</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300 overflow-hidden slide-up" style="animation-delay: 0.1s">
                        <img src="https://images.pexels.com/photos/5452201/pexels-photo-5452201.jpeg?auto=compress&cs=tinysrgb&w=600" alt="Dokter" class="w-full h-64 object-cover">
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-900 mb-1">Dr. Adi Pratama</h3>
                            <p class="text-blue-600 mb-3">Dokter Umum</p>
                            <p class="text-gray-600 mb-4">Spesialis dalam penanganan penyakit umum dengan pengalaman lebih dari 10 tahun dalam praktek medis.</p>
                            <div class="flex space-x-3">
                                <a href="#" class="text-gray-500 hover:text-blue-600 transition-colors duration-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="20" x="2" y="2" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" x2="17.51" y1="6.5" y2="6.5"></line></svg>
                                </a>
                                <a href="#" class="text-gray-500 hover:text-blue-600 transition-colors duration-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 4s-.7 2.1-2 3.4c1.6 10-9.4 17.3-18 11.6 2.2.1 4.4-.6 6-2C3 15.5.5 9.6 3 5c2.2 2.6 5.6 4.1 9 4-.9-4.2 4-6.6 7-3.8 1.1 0 3-1.2 3-1.2z"></path></svg>
                                </a>
                                <a href="#" class="text-gray-500 hover:text-blue-600 transition-colors duration-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"></path><rect width="4" height="12" x="2" y="9"></rect><circle cx="4" cy="4" r="2"></circle></svg>
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300 overflow-hidden slide-up" style="animation-delay: 0.2s">
                        <img src="https://images.pexels.com/photos/5214961/pexels-photo-5214961.jpeg?auto=compress&cs=tinysrgb&w=600" alt="Dokter" class="w-full h-64 object-cover">
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-900 mb-1">Dr. Sari Indah</h3>
                            <p class="text-blue-600 mb-3">Dokter Gigi</p>
                            <p class="text-gray-600 mb-4">Spesialis kesehatan gigi dan mulut dengan fokus pada perawatan estetika dan kesehatan gigi anak.</p>
                            <div class="flex space-x-3">
                                <a href="#" class="text-gray-500 hover:text-blue-600 transition-colors duration-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="20" x="2" y="2" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" x2="17.51" y1="6.5" y2="6.5"></line></svg>
                                </a>
                                <a href="#" class="text-gray-500 hover:text-blue-600 transition-colors duration-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 4s-.7 2.1-2 3.4c1.6 10-9.4 17.3-18 11.6 2.2.1 4.4-.6 6-2C3 15.5.5 9.6 3 5c2.2 2.6 5.6 4.1 9 4-.9-4.2 4-6.6 7-3.8 1.1 0 3-1.2 3-1.2z"></path></svg>
                                </a>
                                <a href="#" class="text-gray-500 hover:text-blue-600 transition-colors duration-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"></path><rect width="4" height="12" x="2" y="9"></rect><circle cx="4" cy="4" r="2"></circle></svg>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300 overflow-hidden slide-up" style="animation-delay: 0.3s">
                        <img src="https://images.pexels.com/photos/5327585/pexels-photo-5327585.jpeg?auto=compress&cs=tinysrgb&w=600" alt="Dokter" class="w-full h-64 object-cover">
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-900 mb-1">Dr. Budi Santoso</h3>
                            <p class="text-blue-600 mb-3">Dokter Spesialis Anak</p>
                            <p class="text-gray-600 mb-4">Ahli dalam tumbuh kembang anak dan penanganan penyakit anak dengan pendekatan yang ramah.</p>
                            <div class="flex space-x-3">
                                <a href="#" class="text-gray-500 hover:text-blue-600 transition-colors duration-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="20" x="2" y="2" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" x2="17.51" y1="6.5" y2="6.5"></line></svg>
                                </a>
                                <a href="#" class="text-gray-500 hover:text-blue-600 transition-colors duration-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 4s-.7 2.1-2 3.4c1.6 10-9.4 17.3-18 11.6 2.2.1 4.4-.6 6-2C3 15.5.5 9.6 3 5c2.2 2.6 5.6 4.1 9 4-.9-4.2 4-6.6 7-3.8 1.1 0 3-1.2 3-1.2z"></path></svg>
                                </a>
                                <a href="#" class="text-gray-500 hover:text-blue-600 transition-colors duration-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"></path><rect width="4" height="12" x="2" y="9"></rect><circle cx="4" cy="4" r="2"></circle></svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-center mt-10">
                    <a href="#" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg inline-flex items-center transition-all transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                        Lihat Semua Dokter
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="ml-2"><path d="m9 18 6-6-6-6"></path></svg>
                    </a>
                </div>
            </div>
        </section>

        <!-- Kontak Section -->
        <section id="kontak" class="py-16 md:py-24 bg-white">
            <div class="container mx-auto px-4">
                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Hubungi Kami</h2>
                    <p class="text-lg text-gray-600 max-w-2xl mx-auto">Jangan ragu untuk menghubungi kami jika Anda memiliki pertanyaan atau ingin membuat janji temu.</p>
                </div>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                    <div class="slide-up" style="animation-delay: 0.1s">
                        <div class="bg-gray-100 rounded-xl p-8 h-full">
                            <h3 class="text-2xl font-bold text-gray-900 mb-6">Informasi Kontak</h3>
                            <div class="space-y-6">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0 mt-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-blue-600"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                                    </div>
                                    <div class="ml-4">
                                        <h4 class="text-lg font-semibold text-gray-900">Alamat</h4>
                                        <p class="text-gray-600 mt-1">Jl. Kesehatan No. 123, Kota Sehat, Indonesia</p>
                                    </div>
                                </div>
                                <div class="flex items-start">
                                    <div class="flex-shrink-0 mt-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-blue-600"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                                    </div>
                                    <div class="ml-4">
                                        <h4 class="text-lg font-semibold text-gray-900">Telepon</h4>
                                        <p class="text-gray-600 mt-1">(021) 123-4567</p>
                                    </div>
                                </div>
                                <div class="flex items-start">
                                    <div class="flex-shrink-0 mt-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-blue-600"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                                    </div>
                                    <div class="ml-4">
                                        <h4 class="text-lg font-semibold text-gray-900">Email</h4>
                                        <p class="text-gray-600 mt-1">info@kliniksehat.com</p>
                                    </div>
                                </div>
                                <div class="flex items-start">
                                    <div class="flex-shrink-0 mt-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-blue-600"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                                    </div>
                                    <div class="ml-4">
                                        <h4 class="text-lg font-semibold text-gray-900">Jam Operasional</h4>
                                        <p class="text-gray-600 mt-1">Senin - Jumat: 08:00 - 20:00</p>
                                        <p class="text-gray-600">Sabtu: 09:00 - 17:00</p>
                                        <p class="text-gray-600">Minggu & Hari Libur: Tutup</p>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-8">
                                <h4 class="text-lg font-semibold text-gray-900 mb-4">Ikuti Kami</h4>
                                <div class="flex space-x-4">
                                    <a href="#" class="w-10 h-10 bg-blue-600 text-white rounded-full flex items-center justify-center hover:bg-blue-700 transition-colors duration-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg>
                                    </a>
                                    <a href="#" class="w-10 h-10 bg-blue-600 text-white rounded-full flex items-center justify-center hover:bg-blue-700 transition-colors duration-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="20" x="2" y="2" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" x2="17.51" y1="6.5" y2="6.5"></line></svg>
                                    </a>
                                    <a href="#" class="w-10 h-10 bg-blue-600 text-white rounded-full flex items-center justify-center hover:bg-blue-700 transition-colors duration-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 4s-.7 2.1-2 3.4c1.6 10-9.4 17.3-18 11.6 2.2.1 4.4-.6 6-2C3 15.5.5 9.6 3 5c2.2 2.6 5.6 4.1 9 4-.9-4.2 4-6.6 7-3.8 1.1 0 3-1.2 3-1.2z"></path></svg>
                                    </a>
                                    <a href="#" class="w-10 h-10 bg-blue-600 text-white rounded-full flex items-center justify-center hover:bg-blue-700 transition-colors duration-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"></path><rect width="4" height="12" x="2" y="9"></rect><circle cx="4" cy="4" r="2"></circle></svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="slide-up" style="animation-delay: 0.2s">
                        <div class="bg-gray-800 text-white rounded-xl p-8 h-full">
                            <h3 class="text-2xl font-bold mb-6">Kirim Pesan</h3>
                            <form>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                    <div>
                                        <label for="name" class="block text-sm font-medium mb-2">Nama Lengkap</label>
                                        <input type="text" id="name" name="name" class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-white placeholder-gray-400" placeholder="Masukkan nama lengkap">
                                    </div>
                                    <div>
                                        <label for="email" class="block text-sm font-medium mb-2">Email</label>
                                        <input type="email" id="email" name="email" class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-white placeholder-gray-400" placeholder="Masukkan email">
                                    </div>
                                </div>
                                <div class="mb-6">
                                    <label for="subject" class="block text-sm font-medium mb-2">Subjek</label>
                                    <input type="text" id="subject" name="subject" class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-white placeholder-gray-400" placeholder="Masukkan subjek">
                                </div>
                                <div class="mb-6">
                                    <label for="message" class="block text-sm font-medium mb-2">Pesan</label>
                                    <textarea id="message" name="message" rows="5" class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-white placeholder-gray-400" placeholder="Tulis pesan Anda disini..."></textarea>
                                </div>
                                <button type="submit" class="w-full px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-all transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                                    Kirim Pesan
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="mt-16 bg-gray-200 rounded-xl overflow-hidden h-64 slide-up" style="animation-delay: 0.3s">
                    <div class="w-full h-full bg-gray-300 flex items-center justify-center">
                        <p class="text-gray-600 font-medium">Peta Lokasi Klinik</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-gray-900 text-white pt-16 pb-6">
            <div class="container mx-auto px-4">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">
                    <div>
                        <div class="flex items-center mb-6">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-blue-400 mr-2"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"></path></svg>
                            <h3 class="text-xl font-bold">Klinik Sehat</h3>
                        </div>
                        <p class="text-gray-400 mb-6">Menyediakan layanan kesehatan terbaik untuk Anda dan keluarga dengan standar kualitas tinggi dan harga terjangkau.</p>
                        <div class="flex space-x-4">
                            <a href="#" class="text-gray-400 hover:text-white transition-colors duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-white transition-colors duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="20" x="2" y="2" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" x2="17.51" y1="6.5" y2="6.5"></line></svg>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-white transition-colors duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 4s-.7 2.1-2 3.4c1.6 10-9.4 17.3-18 11.6 2.2.1 4.4-.6 6-2C3 15.5.5 9.6 3 5c2.2 2.6 5.6 4.1 9 4-.9-4.2 4-6.6 7-3.8 1.1 0 3-1.2 3-1.2z"></path></svg>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-white transition-colors duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"></path><rect width="4" height="12" x="2" y="9"></rect><circle cx="4" cy="4" r="2"></circle></svg>
                            </a>
                        </div>
                    </div>
                    <div>
                        <h4 class="text-lg font-semibold mb-6">Link Cepat</h4>
                        <ul class="space-y-3">
                            <li><a href="#beranda" class="text-gray-400 hover:text-white transition-colors duration-300">Beranda</a></li>
                            <li><a href="#layanan" class="text-gray-400 hover:text-white transition-colors duration-300">Layanan</a></li>
                            <li><a href="#dokter" class="text-gray-400 hover:text-white transition-colors duration-300">Dokter</a></li>
                            <li><a href="#kontak" class="text-gray-400 hover:text-white transition-colors duration-300">Kontak</a></li>
                            <li><a href="#" class="text-gray-400 hover:text-white transition-colors duration-300">FAQ</a></li>
                            <li><a href="#" class="text-gray-400 hover:text-white transition-colors duration-300">Artikel Kesehatan</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="text-lg font-semibold mb-6">Layanan</h4>
                        <ul class="space-y-3">
                            <li><a href="#" class="text-gray-400 hover:text-white transition-colors duration-300">Pemeriksaan Umum</a></li>
                            <li><a href="#" class="text-gray-400 hover:text-white transition-colors duration-300">Kesehatan Gigi</a></li>
                            <li><a href="#" class="text-gray-400 hover:text-white transition-colors duration-300">Kesehatan Ibu & Anak</a></li>
                            <li><a href="#" class="text-gray-400 hover:text-white transition-colors duration-300">Laboratorium</a></li>
                            <li><a href="#" class="text-gray-400 hover:text-white transition-colors duration-300">Kardiologi</a></li>
                            <li><a href="#" class="text-gray-400 hover:text-white transition-colors duration-300">Telemedicine</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="text-lg font-semibold mb-6">Kontak</h4>
                        <ul class="space-y-3">
                            <li class="flex items-start">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-blue-400 mr-3 mt-1"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                                <span class="text-gray-400">Jl. Kesehatan No. 123, Kota Sehat, Indonesia</span>
                            </li>
                            <li class="flex items-start">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-blue-400 mr-3 mt-1"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                                <span class="text-gray-400">(021) 123-4567</span>
                            </li>
                            <li class="flex items-start">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-blue-400 mr-3 mt-1"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                                <span class="text-gray-400">info@kliniksehat.com</span>
                            </li>
                        </ul>
                        <div class="mt-6">
                            <h5 class="text-sm font-semibold mb-3">Subscribe Newsletter</h5>
                            <form class="flex">
                                <input type="email" placeholder="Email Anda" class="px-4 py-2 bg-gray-800 border border-gray-700 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-white placeholder-gray-500 flex-grow">
                                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-r-lg transition-colors duration-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m22 2-7 20-4-9-9-4Z"></path><path d="M22 2 11 13"></path></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="border-t border-gray-800 pt-6">
                    <p class="text-center text-gray-500">&copy; {{ date('Y') }} Klinik Sehat. Semua Hak Dilindungi.</p>
                </div>
            </div>
        </footer>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const navbar = document.getElementById('navbar');
            const brandText = document.getElementById('brand-text');
            const navLinks = document.querySelectorAll('#nav-link-1, #nav-link-2, #nav-link-3, #nav-link-4');
            
            function updateNavbar() {
                if (window.scrollY > 10) {
                    navbar.classList.remove('navbar-transparent');
                    navbar.classList.add('navbar-fixed');
                    brandText.classList.remove('text-white');
                    brandText.classList.add('text-gray-800');
                    navLinks.forEach(link => {
                        link.classList.remove('text-white', 'hover:text-blue-200');
                        link.classList.add('text-gray-700', 'hover:text-blue-600');
                    });
                } else {
                    navbar.classList.remove('navbar-fixed');
                    brandText.classList.remove('text-gray-800');
                    navLinks.forEach(link => {
                        link.classList.remove('text-gray-700', 'hover:text-blue-600');
                    });
                }
            }
            
            window.addEventListener('scroll', updateNavbar);
            updateNavbar();
            
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');
            
            mobileMenuButton.addEventListener('click', function() {
                mobileMenu.classList.toggle('hidden');
            });
            
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    const targetId = this.getAttribute('href');
                    if (targetId === '#') return;
                    
                    const targetElement = document.querySelector(targetId);
                    if (targetElement) {
                        targetElement.scrollIntoView({
                            behavior: 'smooth'
                        });
                        
                        if (!mobileMenu.classList.contains('hidden')) {
                            mobileMenu.classList.add('hidden');
                        }
                    }
                });
            });
        });
    </script>
</body>
</html>