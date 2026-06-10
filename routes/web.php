<?php

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\User\ProductController as UserProductController;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\OrderController;
use App\Http\Controllers\User\ReviewController as UserReviewController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\ReviewController as AdminReviewController;

// Guest
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/shop', function (Request $request) {
    $query = Product::where('sold', false);

    if ($request->filled('category') && $request->category !== 'ALL') {
        $query->where('category', $request->category);
    }
    if ($request->filled('min_price')) {
        $query->where('price', '>=', $request->min_price);
    }
    if ($request->filled('max_price')) {
        $query->where('price', '<=', $request->max_price);
    }
    if ($request->filled('sort')) {
        if ($request->sort == 'price_asc') $query->orderBy('price', 'asc');
        elseif ($request->sort == 'price_desc') $query->orderBy('price', 'desc');
        elseif ($request->sort == 'newest') $query->latest();
    }

    $availableProducts = $query->get();
    $currentCategory = $request->category ?? 'ALL PRODUCTS';

    return view('shop', compact('availableProducts', 'currentCategory'));
})->name('shop');

// Public pages
Route::view('/how-to-order', 'how-to-order')->name('how.to.order');
Route::view('/our-store', 'our-store')->name('our.store');
Route::view('/faq', 'faq')->name('faq');

// Public product catalog
Route::prefix('user')->name('user.')->group(function () {
    Route::get('/products', [UserProductController::class, 'index'])->name('products.index');
    Route::get('/products/{id}', [UserProductController::class, 'show'])->name('products.show');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::redirect('/user', '/user/products');

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile');
    Route::get('/checkout', function () {
        $cartItems = \App\Models\CartItem::with('product')->where('user_id', auth()->id())->get();
        if ($cartItems->isEmpty()) {
            return redirect()->route('shop')->with('info', 'Keranjang belanja kosong. Tambahkan produk terlebih dahulu.');
        }
        return view('user.checkout', compact('cartItems'));
    })->name('checkout');
    Route::post('/checkout/process', [\App\Http\Controllers\CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/checkout/success/{id}', [\App\Http\Controllers\CheckoutController::class, 'showSuccess'])->name('checkout.success');
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/user/cart', [CartController::class, 'store'])->name('user.cart.store');
    Route::delete('/cart/{id}', [\App\Http\Controllers\User\CartController::class, 'destroy'])->name('cart.destroy');
    Route::get('/user/history', function () { return view('user.history'); })->name('user.history');
    Route::get('/user/reviews', [\App\Http\Controllers\User\ReviewController::class, 'index'])->name('user.reviews');
    Route::post('/user/reviews', [\App\Http\Controllers\User\ReviewController::class, 'store'])->name('user.reviews.store');
    Route::get('/user/settings', [ProfileController::class, 'edit'])->name('user.settings');
    Route::put('/user/settings', [ProfileController::class, 'update'])->name('user.settings.update');
});

Route::prefix('user')->name('user.')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

// Admin
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/products', [AdminProductController::class, 'index'])->name('products.index');
    Route::post('/products', [AdminProductController::class, 'store'])->name('products.store');
    Route::post('/products/{product}/sold', [AdminProductController::class, 'markSold'])->name('products.markSold');
    Route::get('/orders', [\App\Http\Controllers\Admin\OrderController::class, 'index'])->name('orders.index');
    Route::patch('/orders/{id}/mark-paid', [\App\Http\Controllers\Admin\OrderController::class, 'markPaid'])->name('orders.markPaid');
    Route::get('/reviews', [AdminReviewController::class, 'index'])->name('reviews.index');
    Route::post('/reviews/{review}/reply', [AdminReviewController::class, 'reply'])->name('reviews.reply');
});



// API Lokasi (Kommerce)
Route::get('/api/location/provinces', [\App\Http\Controllers\CheckoutController::class, 'getProvinces']);
Route::get('/api/location/cities/{province_id}', [\App\Http\Controllers\CheckoutController::class, 'getCities']);
Route::get('/api/location/districts/{city_id}', [\App\Http\Controllers\CheckoutController::class, 'getDistricts']);

// API Shipping Cost
Route::get('/api/shipping/cost', [\App\Http\Controllers\CheckoutController::class, 'getShippingCost']);