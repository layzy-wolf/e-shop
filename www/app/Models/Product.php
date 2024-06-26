<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;

    protected $guarded = ["id"];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function baskets(): BelongsToMany
    {
        return $this->belongsToMany(Basket::class, "product_basket")->withPivot("amount", "price");
    }
}
