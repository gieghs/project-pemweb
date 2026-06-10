<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin — White North Store</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex h-screen w-full bg-gray-50 overflow-hidden font-sans">
    <aside class="w-64 bg-white border-r border-gray-200 flex flex-col flex-shrink-0 h-full">
        <div class="p-6 border-b border-gray-200">
            <h1 class="text-xl font-bold text-black">WHITE NORTH</h1>
            <p class="text-sm text-gray-500">Admin Panel</p>
        </div>
        <nav class="flex-1 p-4">
            @php
                $menuItems = [
                    ['path' => '/admin', 'icon' => 'dashboard', 'label' => 'Dashboard'],
                    ['path' => '/admin/products', 'icon' => 'package', 'label' => 'Products'],
                    ['path' => '/admin/orders', 'icon' => 'message-square', 'label' => 'Orders'],
                    ['path' => '/admin/reviews', 'icon' => 'store', 'label' => 'View Store'],
                ];
            @endphp
            @foreach ($menuItems as $item)
                @php
                    $active = request()->path() === trim($item['path'], '/');
                @endphp
                <a href="{{ url($item['path']) }}"
                    class="w-full flex items-center gap-3 px-4 py-3 rounded-lg mb-2 transition-colors {{ $active ? 'bg-black text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                    @if ($item['icon'] === 'dashboard')
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/><rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/></svg>
                    @elseif ($item['icon'] === 'package')
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m7.5 4.27 9 5.15"/><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/><path d="m3.3 7 8.7 5.27 8.7-5.27"/><path d="M12 22V12"/></svg>
                    @elseif ($item['icon'] === 'message-square')
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                    @elseif ($item['icon'] === 'store')
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m2 7 4.41-4.41A2 2 0 0 1 7.83 2h8.34a2 2 0 0 1 1.42.59L22 7"/><path d="M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8"/><path d="M15 22v-4a2 2 0 0 0-2-2h-2a2 2 0 0 0-2 2v4"/><path d="M2 7h20"/><path d="M22 7v3a2 2 0 0 1-2 2v0a2.7 2.7 0 0 1-1.59-.63.7.7 0 0 0-.82 0A2.7 2.7 0 0 1 16 12a2.7 2.7 0 0 1-1.59-.63.7.7 0 0 0-.82 0A2.7 2.7 0 0 1 12 12a2.7 2.7 0 0 1-1.59-.63.7.7 0 0 0-.82 0A2.7 2.7 0 0 1 8 12a2.7 2.7 0 0 1-1.59-.63.7.7 0 0 0-.82 0A2.7 2.7 0 0 1 4 12v0a2 2 0 0 1-2-2V7"/></svg>
                    @endif
                    <span class="font-medium">{{ $item['label'] }}</span>
                </a>
            @endforeach
        </nav>
    </aside>

    <div class="flex-1 flex flex-col h-full overflow-hidden">
        <header class="bg-white border-b border-gray-200 h-16 flex items-center justify-end px-8 flex-shrink-0 w-full">
            <form method="POST" action="{{ url('/logout') }}">
                @csrf
                <button type="submit"
                    class="w-10 h-10 bg-black text-white rounded-full flex items-center justify-center hover:bg-gray-800 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                </button>
            </form>
        </header>
        <main class="flex-1 overflow-y-auto p-8 w-full">
            @yield('content')
        </main>
    </div>
</div>
</body>
</html>
