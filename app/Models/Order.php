<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'product_id',
        'product_name',
        'user_id',
        'username',
        'price',
        'payment_method',
        'shipping_cost',
        'status',
        'phone',
        'address',
        'district',
        'city',
        'province',
        'postal_code',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'integer',
        ];
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}