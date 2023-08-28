<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_name',
        'quantity',
        'price',
    ];
    public function orders()
    {
        return $this->belongsToMany(Order::class);
    }

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
}
