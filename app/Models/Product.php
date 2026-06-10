<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    const STATUS_AVAILABLE = 'available';
    const STATUS_SOLD = 'sold';

    protected $fillable = [
        'name',
        'description',
        'price',
        'category',
        'sold',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'integer',
            'sold' => 'boolean',
        ];
    }

    public function isAvailable(): bool
    {
        return $this->status === self::STATUS_AVAILABLE;
    }

    public function isSold(): bool
    {
        return $this->status === self::STATUS_SOLD;
    }

    public function scopeAvailable($query)
    {
        return $query->where('status', self::STATUS_AVAILABLE);
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    public function imageUrl(): string
    {
        $firstImage = $this->images->first();

        if (!$firstImage || empty($firstImage->image_path)) {
            return 'data:image/svg+xml,' . rawurlencode('<svg xmlns="http://www.w3.org/2000/svg" width="400" height="400" fill="#f3f4f6"><rect width="400" height="400"/><text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle" fill="#9ca3af" font-size="14" font-family="sans-serif">No Image</text></svg>');
        }

        $path = $firstImage->image_path;

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        return asset('storage/' . $path);
    }
}