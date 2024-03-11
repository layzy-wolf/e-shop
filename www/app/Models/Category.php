<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $guarded = ["id"];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, "category_id");
    }

    public function child(): HasMany
    {
        return $this->hasMany(Category::class, "category_id");
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
