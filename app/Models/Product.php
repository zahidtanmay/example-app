<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'user_id',
        'photo_path',
        'manufactured_year'
    ];

    public function user()
    {
        $this->belongsTo(User::class);
    }

    public function setUserIdAttribute($value)
    {
        $this->attributes['user_id'] = auth()->user()->id;
    }
}
