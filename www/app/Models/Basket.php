<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Basket extends Model
{
    use HasFactory;

    protected $guarded = ["id"];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, "product_basket")->withPivot("amount", "price");
    }

    public function order(): HasOne
    {
        return $this->hasOne(Order::class);
    }
}
