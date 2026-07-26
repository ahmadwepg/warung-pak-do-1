<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $fillable = [
        'cart_id',
        'product_id',
        'variant_value',
        'quantity',
    ];

    protected $casts = [
        'quantity' => 'integer',
    ];

    protected $appends = [
        'subtotal',
        'image_url',
    ];

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getSubtotalAttribute(): int
    {
        return (int) ($this->product?->price ?? 0) * (int) $this->quantity;
    }

    public function getImageUrlAttribute(): string
    {
        return $this->product?->image
            ? asset('storage/'.$this->product->image)
            : 'https://placehold.co/400x300/png?text='.urlencode($this->product?->name ?? 'Warung Pak Do');
    }
}
