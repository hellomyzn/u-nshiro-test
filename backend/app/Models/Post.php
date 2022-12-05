<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;

class Post extends Model
{
    use HasFactory;

    const OPEN = 1;
    const CLOSE = 0;

    const STATUS = [
        self::OPEN => 'Open', 
        self::CLOSE => 'Close',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function scopeOnlyOpen($query)
    {
        return $query->where('status',self::OPEN);
    }

    public function isClosed()
    {
        return $this->status == self::CLOSE;
    }
}
