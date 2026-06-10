<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>White North Store</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="min-h-screen bg-gray-50 flex flex-col">
    <header id="smart-navbar" class="fixed top-0 left-0 right-0 w-full z-[100] transition-all duration-300 ease-in-out transform-gpu translate-y-0 {{ request()->is('/') ? 'bg-transparent text-white' : 'bg-white text-black border-b border-gray-200 shadow-sm' }}">
        <div class="flex items-center justify-between px-6 py-6 relative w-full">
            <div class="z-10">
                <button onclick="openProfile()" class="text-[10px] md:text-[11px] font-bold tracking-[0.2em] uppercase transition-colors hover:text-gray-500">PROFILE</button>
            </div>
            
            <div class="absolute left-1/2 transform -translate-x-1/2 z-0">
                <a href="{{ url('/') }}" class="block hover:opacity-50 transition-opacity text-current">
                    <svg class="w-8 h-8 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 0L14.5 9.5L24 12L14.5 14.5L12 24L9.5 14.5L0 12L9.5 9.5L12 0Z"/>
                    </svg>
                </a>
            </div>
            
            <div class="flex gap-4 md:gap-6 z-10">
                <button onclick="openCart()" class="text-[10px] md:text-[11px] font-bold tracking-[0.2em] uppercase transition-colors hover:text-gray-500">CART ({{ $globalCart->count() }})</button>
            </div>
        </div>
    </header>

    <main class="flex-1 {{ request()->is('/') ? '' : 'pt-24' }}">
        @yield('content')
    </main>

    @include('components.footer')

    @if (isset($showReviewPopup) && $showReviewPopup)
        <div id="review-popup" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
            <div class="bg-white p-8 max-w-md w-full text-center">
                <div class="mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="#EAB308" stroke="#EAB308" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mx-auto"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                </div>
                <h3 class="text-2xl font-bold mb-3">Bagaimana pengalaman Anda?</h3>
                <p class="text-gray-600 mb-6">Kami sangat menghargai pendapat Anda! Berikan ulasan untuk membantu kami meningkatkan layanan.</p>
                <div class="flex flex-col gap-3">
                    <a href="{{ url('/user/reviews') }}" class="w-full bg-black text-white px-6 py-3 hover:bg-gray-800 font-semibold">Kirim Ulasan</a>
                    <button onclick="this.closest('#review-popup').classList.add('hidden')" class="w-full bg-gray-200 text-black px-6 py-3 hover:bg-gray-300 font-semibold">Ingatkan Nanti</button>
                </div>
            </div>
        </div>
    @endif
    <!-- Login Modal (for guests) -->
    <div id="login-modal" class="fixed inset-0 bg-black/40 z-[130] hidden items-center justify-center p-4" onclick="hideLoginModal(event)">
        <div class="bg-white p-8 max-w-sm w-full text-center" onclick="event.stopPropagation()">
            <div class="mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="mx-auto text-gray-300"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            </div>
            <h3 class="text-sm font-bold uppercase tracking-[0.2em] mb-3">Masuk untuk Melanjutkan</h3>
            <p class="text-xs text-gray-500 mb-6">Silakan login atau daftar akun untuk menambahkan produk ke keranjang.</p>
            <div class="flex flex-col gap-3">
                <a href="{{ route('login') }}?redirect={{ url()->current() }}" class="w-full bg-black text-white px-6 py-3 text-[11px] font-bold tracking-[0.2em] uppercase hover:bg-gray-800 transition-colors">LOGIN</a>
                <button onclick="hideLoginModal()" class="w-full border border-black text-black px-6 py-3 text-[11px] font-bold tracking-[0.2em] uppercase hover:bg-gray-100 transition-colors">BATAL</button>
                 <div class="mt-3 mb-3 text-center text-xs md:text-sm text-gray-600">
                    Belum punya akun? <a href="{{ route('register') }}" class="font-bold text-black underline hover:text-gray-800 transition-colors">Daftar</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Cart Overlay -->
    <div id="cart-overlay" class="fixed inset-0 bg-black/40 z-[110] hidden opacity-0 transition-opacity duration-300" onclick="closeCart()"></div>

    <!-- Cart Drawer -->
    <div id="cart-panel" class="fixed top-0 right-0 w-full md:w-[400px] h-full bg-white z-[120] transform translate-x-full transition-transform duration-300 ease-in-out flex flex-col">
        <div class="flex justify-between items-center p-6 border-b border-gray-200">
            <h2 class="text-xs font-bold tracking-[0.2em] uppercase">CART</h2>
            <button onclick="closeCart()" class="text-lg text-gray-500 hover:text-black">&times;</button>
        </div>

        <div id="cart-drawer-body" class="flex-1 flex flex-col">
            @php
                $_cartItems = auth()->check()
                    ? auth()->user()->cartItems()->with('product')->get()->filter(fn ($i) => $i->product && !$i->product->sold)->values()
                    : collect([]);
                $_totalPrice = $_cartItems->sum(fn ($i) => $i->product->price);
            @endphp
            @include('components.cart-drawer-items', ['cartItems' => $_cartItems, 'totalPrice' => $_totalPrice])
        </div>
    </div>

    <!-- Profile Drawer -->
    <div id="profile-panel" class="fixed top-0 left-0 w-full md:w-[350px] h-full bg-white z-[120] transform -translate-x-full transition-transform duration-300 ease-in-out flex flex-col text-black">
        <div class="flex justify-between items-center p-6 border-b border-black">
            <h2 class="text-xs font-bold tracking-[0.2em] uppercase">PROFILE</h2>
            <button onclick="closeProfile()" class="text-xl font-light text-gray-500 hover:text-black transition-colors leading-none">&times;</button>
        </div>
        
        <div class="flex-1 overflow-y-auto p-6">
            @auth
            <div class="flex flex-col h-full">
                <!-- User Info -->
                <div class="pb-6 border-b border-gray-200 mb-6">
                    <p class="text-[10px] font-bold tracking-[0.2em] uppercase text-gray-500 mb-2">LOGGED IN AS</p>
                    <p class="text-base font-bold truncate">{{ auth()->user()->username ?? 'USER' }}</p>
                </div>

                <!-- Menu Items -->
                <nav class="flex-1 flex flex-col gap-4 mb-8">
                    <a href="{{ route('user.history') }}" class="group flex items-center justify-between px-4 py-5 border border-black bg-white hover:bg-black hover:text-white transition-all duration-200 ease-out">
                        <div class="flex items-center gap-4">
                            <svg class="w-5 h-5 text-black group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span class="text-[11px] font-bold tracking-[0.2em] uppercase">HISTORY BELANJA</span>
                        </div>
                        <svg class="w-4 h-4 text-black group-hover:text-white transition-colors flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                    <a href="{{ route('user.reviews') }}" class="group flex items-center justify-between px-4 py-5 border border-black bg-white hover:bg-black hover:text-white transition-all duration-200 ease-out">
                        <div class="flex items-center gap-4">
                            <svg class="w-5 h-5 text-black group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 011-1h1a2 2 0 100-4h-1a1 1 0 01-1-1V7a1 1 0 011-1h3a1 1 0 001-1V4z"></path></svg>
                            <span class="text-[11px] font-bold tracking-[0.2em] uppercase">BERI ULASAN</span>
                        </div>
                        <svg class="w-4 h-4 text-black group-hover:text-white transition-colors flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                    <a href="{{ route('user.settings') }}" class="group flex items-center justify-between px-4 py-5 border border-black bg-white hover:bg-black hover:text-white transition-all duration-200 ease-out">
                        <div class="flex items-center gap-4">
                            <svg class="w-5 h-5 text-black group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <span class="text-[11px] font-bold tracking-[0.2em] uppercase">SETTING PROFIL</span>
                        </div>
                        <svg class="w-4 h-4 text-black group-hover:text-white transition-colors flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                </nav>

                <!-- Logout Button -->
                <form method="POST" action="{{ route('logout') }}" class="mt-auto pt-6">
                    @csrf
                    <button type="submit" class="w-full bg-black text-white py-5 text-[11px] font-bold tracking-[0.2em] uppercase hover:bg-gray-900 transition-colors border-none">
                        LOGOUT
                    </button>
                </form>
            </div>
            @else
            <div class="flex flex-col gap-6 items-center text-center h-full justify-center">
                <p class="text-xs text-gray-500 leading-loose max-w-xs">Silakan login untuk mengakses profil, riwayat belanja, dan melacak pesanan Anda.</p>
                <a href="{{ route('login') }}" class="w-full bg-black text-white py-4 text-[11px] font-bold tracking-[0.2em] uppercase hover:bg-gray-800 transition-colors">LOGIN</a>
                <a href="{{ route('register') }}" class="w-full bg-white text-black border border-black py-4 text-[11px] font-bold tracking-[0.2em] uppercase hover:bg-black hover:text-white transition-colors">REGISTER</a>
            </div>
            @endauth
        </div>
    </div>

    <script>
        let lastScrollTop = 0;
        const navbar = document.getElementById('smart-navbar');
        const isHomePage = {{ request()->is('/') ? 'true' : 'false' }};

        window.addEventListener('scroll', function() {
            let scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            
            if (isHomePage) {
                if (scrollTop > 50) {
                    navbar.classList.remove('bg-transparent', 'text-white');
                    navbar.classList.add('bg-white', 'text-black', 'border-b', 'border-gray-200');
                } else {
                    navbar.classList.add('bg-transparent', 'text-white');
                    navbar.classList.remove('bg-white', 'text-black', 'border-b', 'border-gray-200');
                }
            }

            if (scrollTop > lastScrollTop && scrollTop > 100) {
                navbar.classList.remove('translate-y-0');
                navbar.classList.add('-translate-y-full');
            } else {
                navbar.classList.remove('-translate-y-full');
                navbar.classList.add('translate-y-0');
            }
            lastScrollTop = scrollTop <= 0 ? 0 : scrollTop;
        });

        function openCart() {
            const overlay = document.getElementById('cart-overlay');
            const panel = document.getElementById('cart-panel');
            
            document.body.classList.add('overflow-hidden');
            
            overlay.classList.remove('hidden');
            setTimeout(() => {
                overlay.classList.remove('opacity-0');
                panel.classList.remove('translate-x-full');
            }, 10);
        }

        function closeCart() {
            const overlay = document.getElementById('cart-overlay');
            const panel = document.getElementById('cart-panel');
            
            document.body.classList.remove('overflow-hidden');
            
            overlay.classList.add('opacity-0');
            panel.classList.add('translate-x-full');
            setTimeout(() => {
                overlay.classList.add('hidden');
            }, 300);
        }

        function openProfile() {
            const overlay = document.getElementById('cart-overlay');
            const panel = document.getElementById('profile-panel');
            
            document.body.classList.add('overflow-hidden');
            
            overlay.onclick = closeProfile;
            
            overlay.classList.remove('hidden');
            setTimeout(() => {
                overlay.classList.remove('opacity-0');
                panel.classList.remove('-translate-x-full');
            }, 10);
        }

        function closeProfile() {
            const overlay = document.getElementById('cart-overlay');
            const panel = document.getElementById('profile-panel');
            
            document.body.classList.remove('overflow-hidden');
            
            overlay.classList.add('opacity-0');
            panel.classList.add('-translate-x-full');
            
            setTimeout(() => {
                overlay.classList.add('hidden');
                overlay.onclick = closeCart;
            }, 300);
        }

        function getCsrfToken() {
            return document.querySelector('meta[name="csrf-token"]').content;
        }

        function showLoginModal() {
            document.getElementById('login-modal').classList.remove('hidden');
            document.getElementById('login-modal').classList.add('flex');
            document.body.classList.add('overflow-hidden');
        }

        function hideLoginModal(event) {
            if (event && event.target !== event.currentTarget) return;
            document.getElementById('login-modal').classList.add('hidden');
            document.getElementById('login-modal').classList.remove('flex');
            document.body.classList.remove('overflow-hidden');
        }

    </script>

    @if (session('open_cart'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            openCart();
        });
    </script>
    @endif
</body>
</html>
