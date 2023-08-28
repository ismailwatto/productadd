<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Order extends Model
{
    use HasFactory;
  
    protected $fillable = [
      'user_id',  'discounted_amount', 'sub_total', 'discount_type', 'final_price',
    ];
    public function items()
    {
        return $this->belongsToMany(Item::class)
            ->withPivot('quantity','total_price', 'total_quantity');
    }    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
