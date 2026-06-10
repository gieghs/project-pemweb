<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\Review;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ─────────────────────────────────────────────
        // Users
        // ─────────────────────────────────────────────
        $admin = User::create([
            'username' => 'admin',
            'email' => 'admin@whitenorthstore.com',
            'password' => Hash::make('admin 123'),
            'role' => 'admin',
        ]);

        $user = User::create([
            'username' => 'dono',
            'email' => 'dono@example.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'address' => 'Jl. Merdeka No. 45, Jakarta Pusat, DKI Jakarta 10110',
        ]);

        $user2 = User::create([
            'username' => 'siti',
            'email' => 'siti@example.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'address' => 'Jl. Sudirman No. 12, Bandung, Jawa Barat 40123',
        ]);

        // ─────────────────────────────────────────────
        // Products
        // ─────────────────────────────────────────────
        $products = collect();
        $productData = [
            [
                'name' => 'Classic Trucker Cap Black',
                'description' => 'Topi trucker cap vintage dengan mesh di bagian belakang. Nyaman untuk aktivitas outdoor. Bahan premium dengan jahitan rapi.',
                'price' => 125000,
                'image' => 'https://images.unsplash.com/photo-1588850561407-ed78c282e89b?w=400',
                'category' => 'Trucker Cap',
            ],
            [
                'name' => 'Brown Flat Cap',
                'description' => 'Flat cap klasik dengan bahan wool premium. Perfect untuk gaya vintage dan retro. Tersedia dalam berbagai ukuran.',
                'price' => 180000,
                'image' => 'https://images.unsplash.com/photo-1534215754734-18e55d13e346?w=400',
                'category' => 'Flat Cap',
            ],
            [
                'name' => 'White Bucket Hat',
                'description' => 'Bucket hat putih yang trendy. Cocok untuk streetwear dan casual style. Material katun berkualitas tinggi.',
                'price' => 95000,
                'image' => 'https://images.unsplash.com/photo-1576871337632-b9aef4c17ab9?w=400',
                'category' => 'Bucket Hat',
            ],
            [
                'name' => 'Olive Jungle Hat',
                'description' => 'Jungle hat dengan wide brim untuk perlindungan maksimal dari sinar matahari. Bahan ringan dan nyaman dipakai seharian.',
                'price' => 145000,
                'image' => 'https://images.unsplash.com/photo-1529958030586-3aae4ca485ff?w=400',
                'category' => 'Jungle Hat',
            ],
            [
                'name' => 'Navy Baseball Cap',
                'description' => 'Baseball cap klasik dengan logo vintage. Material cotton berkualitas tinggi dengan jahitan ganda untuk daya tahan.',
                'price' => 110000,
                'image' => 'https://images.unsplash.com/photo-1575428652377-a2d80e2277fc?w=400',
                'category' => 'Baseball Cap',
            ],
            [
                'name' => 'Black Snapback',
                'description' => 'Snapback dengan flat brim dan adjustable snap closure. Urban style essential untuk daily look.',
                'price' => 135000,
                'image' => 'https://images.unsplash.com/photo-1588850561407-ed78c282e89b?w=400',
                'category' => 'Snapback',
            ],
            [
                'name' => 'Grey Newsboy Cap',
                'description' => 'Newsboy cap dengan 8 panel design. Elegan untuk formal maupun casual. Bahan wool blend dengan lining premium.',
                'price' => 165000,
                'image' => 'https://images.unsplash.com/photo-1521369909029-2afed882baee?w=400',
                'category' => 'Newsboy Cap',
            ],
        ];

        foreach ($productData as $data) {
            $imageUrl = $data['image'];
            unset($data['image']);
            $product = Product::create($data);
            $product->images()->create([
                'image_path' => $imageUrl,
                'sort_order' => 1,
            ]);
            $products->push($product);
        }

        // Mark one product as sold
        $soldProduct = $products[4]; // Navy Baseball Cap
        $soldProduct->update(['sold' => true]);

        // ─────────────────────────────────────────────
        // Cart Items
        // ─────────────────────────────────────────────
        CartItem::create([
            'product_id' => $products[0]->id, // Trucker Cap
            'user_id' => $user->id,
        ]);

        CartItem::create([
            'product_id' => $products[2]->id, // Bucket Hat
            'user_id' => $user->id,
        ]);

        CartItem::create([
            'product_id' => $products[5]->id, // Snapback
            'user_id' => $user2->id,
        ]);

        // ─────────────────────────────────────────────
        // Orders (History)
        // ─────────────────────────────────────────────
        Order::create([
            'product_id' => $soldProduct->id,
            'product_name' => $soldProduct->name,
            'user_id' => $user->id,
            'username' => $user->username,
            'price' => $soldProduct->price,
            'created_at' => now()->subDays(5),
        ]);

        Order::create([
            'product_id' => $products[6]->id, // Grey Newsboy Cap
            'product_name' => $products[6]->name,
            'user_id' => $user2->id,
            'username' => $user2->username,
            'price' => $products[6]->price,
            'created_at' => now()->subDays(2),
        ]);

        // ─────────────────────────────────────────────
        // Reviews
        // ─────────────────────────────────────────────
        $review = Review::create([
            'user_id' => $user->id,
            'username' => $user->username,
            'rating' => 5,
            'comment' => 'Topinya bagus banget! Kualitas bahan premium, jahitan rapi, dan pengiriman cepat banget. Sangat recommended untuk kolektor topi vintage!',
            'created_at' => now()->subDays(4),
        ]);

        Review::create([
            'user_id' => $user2->id,
            'username' => $user2->username,
            'rating' => 4,
            'comment' => 'Produk sesuai dengan gambar. Kualitas ok, cuma pengiriman agak lama. Tapi overall puas dengan pembelian.',
            'created_at' => now()->subDay(),
        ]);

        // Add admin reply to the first review
        $review->update([
            'admin_reply' => 'Terima kasih banyak atas ulasan positifnya! Senang mendengar Anda puas dengan produk kami. Kami akan terus menjaga kualitas dan pelayanan terbaik. Sampai jumpa di pembelian berikutnya! 🙌',
            'admin_reply_date' => now()->subDays(3),
        ]);
    }
}
