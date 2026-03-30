<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Perpustakaan</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="flex h-screen overflow-hidden bg-white font-sans">

    {{-- Sidebar --}}
    <aside class="w-[270px] flex-shrink-0 overflow-y-auto custom-scrollbar">
        @include('components.admin.sidebar')
    </aside>

    {{-- Main Content --}}
    <main class="flex-1 overflow-y-auto custom-scrollbar-light">

        {{-- Top Bar --}}
        <div class="sticky top-0 z-30 bg-white/90 backdrop-blur-lg border-b border-gray-100 px-8 py-4">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-gray-800">@yield('page-title', 'Admin Panel')</h2>
                    <p class="text-xs text-gray-400 mt-0.5">@yield('page-subtitle', 'Perpustakaan Digital')</p>
                </div>
                <div class="flex items-center gap-3">
                    <span class="text-sm text-gray-500 bg-[#F3F4F6] px-4 py-2 rounded-xl">
                        <i class="fa-regular fa-calendar mr-1 text-[#14B8A6]"></i>
                        {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
                    </span>
                </div>
            </div>
        </div>

        {{-- Toast --}}
        <div class="px-8 pt-4">
            @if (session('success'))
                <div class="toast-enter bg-teal-50 border border-teal-200 text-teal-700 px-5 py-3.5 rounded-xl mb-4 flex items-center gap-3 shadow-sm">
                    <div class="w-8 h-8 bg-[#14B8A6] rounded-lg flex items-center justify-center flex-shrink-0">
                        <i class="fa-solid fa-check text-white text-sm"></i>
                    </div>
                    <span class="text-sm font-medium">{{ session('success') }}</span>
                </div>
            @endif
        </div>

        {{-- Page Content --}}
        <div class="px-8 pb-8">
            @yield('content')
        </div>

    </main>

</body>

</html>
