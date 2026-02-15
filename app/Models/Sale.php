<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Sale extends Model
{
    protected $fillable = ['product_id', 'user_id', 'quantity_sold', 'unit_cost', 'sale_price', 'revenue', 'sold_at'];
    protected $casts = [
        'unit_cost' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'revenue' => 'decimal:2',
        'sold_at' => 'datetime',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
