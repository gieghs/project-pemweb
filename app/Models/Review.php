<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'user_id',
        'username',
        'rating',
        'comment',
        'admin_reply',
        'admin_reply_date',
    ];

    protected function casts(): array
    {
        return [
            'rating' => 'integer',
            'admin_reply_date' => 'datetime',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}