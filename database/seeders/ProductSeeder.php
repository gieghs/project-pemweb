<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::truncate();
        Product::insert([
            ['name' => 'Classic Trucker Cap Black', 'category' => 'Trucker Cap', 'price' => 125000, 'description' => 'Classic black trucker cap with mesh back.', 'image' => 'https://images.unsplash.com/photo-1588850561407-ed78c282e89b?auto=format&fit=crop&w=500&q=80', 'sold' => false],
            ['name' => 'Red Vintage Trucker', 'category' => 'Trucker Cap', 'price' => 110000, 'description' => 'Vintage red trucker cap with curved brim.', 'image' => 'https://images.unsplash.com/photo-1622470953794-aa9c70b0fb1d?auto=format&fit=crop&w=500&q=80', 'sold' => false],
            ['name' => 'Brown Flat Cap', 'category' => 'Flat Cap', 'price' => 180000, 'description' => 'Classic brown flat cap made of wool blend.', 'image' => 'https://images.unsplash.com/photo-1520063802958-ee2bce2bc60c?auto=format&fit=crop&w=500&q=80', 'sold' => false],
            ['name' => 'White Bucket Hat', 'category' => 'Bucket Hat', 'price' => 95000, 'description' => 'Clean white bucket hat for summer style.', 'image' => 'https://images.unsplash.com/photo-1618354691792-d1d42acfd860?auto=format&fit=crop&w=500&q=80', 'sold' => false],
            ['name' => 'Black Denim Bucket Hat', 'category' => 'Bucket Hat', 'price' => 105000, 'description' => 'Durable black denim bucket hat.', 'image' => 'https://images.unsplash.com/photo-1576871337622-98d48d1cf531?auto=format&fit=crop&w=500&q=80', 'sold' => false],
            ['name' => 'Olive Jungle Hat', 'category' => 'Jungle Hat', 'price' => 145000, 'description' => 'Olive green jungle hat with wide brim.', 'image' => 'https://images.unsplash.com/photo-1534062630501-b27b3bba1298?auto=format&fit=crop&w=500&q=80', 'sold' => false],
            ['name' => 'Camo Jungle Hat', 'category' => 'Jungle Hat', 'price' => 155000, 'description' => 'Camo pattern jungle hat for outdoor adventures.', 'image' => 'https://images.unsplash.com/photo-1582841074465-b7e5399f0e1c?auto=format&fit=crop&w=500&q=80', 'sold' => false],
            ['name' => 'Black Snapback', 'category' => 'Snapback', 'price' => 130000, 'description' => 'Classic black snapback with flat brim.', 'image' => 'https://images.unsplash.com/photo-1556306535-0f09a536f0ab?auto=format&fit=crop&w=500&q=80', 'sold' => false],
            ['name' => 'Classic Snapback Navy', 'category' => 'Snapback', 'price' => 135000, 'description' => 'Navy blue snapback with embroidered logo.', 'image' => 'https://images.unsplash.com/photo-1570196238382-74f4b1d50c1d?auto=format&fit=crop&w=500&q=80', 'sold' => false],
            ['name' => 'Grey Newsboy Cap', 'category' => 'Newsboy Cap', 'price' => 160000, 'description' => 'Grey wool newsboy cap with button top.', 'image' => 'https://images.unsplash.com/photo-1554568218-0f1715e72254?auto=format&fit=crop&w=500&q=80', 'sold' => false],
        ]);
    }
}
