<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ["basket_id", "user_id"];

    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function basket(): HasOne
    {
        return $this->hasOne(Basket::class, "id", "basket_id");
    }
}
