<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'order_number',
        'status',
        'total_price',
        'delivery_method',
        'address',
        'phone',
        'payment_method',
        'payment_status',
    ];

    protected $casts = [
        'total_price' => 'integer',
    ];

    protected static function booted(): void
    {
        static::creating(function (self $order) {
            if (blank($order->order_number)) {
                do {
                    $orderNumber = 'ORD-'.now()->format('Ymd').'-'.str_pad((string) random_int(0, 9999), 4, '0', STR_PAD_LEFT);
                } while (static::where('order_number', $orderNumber)->exists());

                $order->order_number = $orderNumber;
            }
        });
    }

    public function getRouteKeyName(): string
    {
        return 'order_number';
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'yellow',
            'diterima' => 'blue',
            'disiapkan' => 'indigo',
            'dikirim' => 'purple',
            'selesai' => 'green',
            'dibatalkan' => 'red',
            default => 'gray',
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'Menunggu Konfirmasi',
            'diterima' => 'Pesanan Diterima',
            'disiapkan' => 'Sedang Disiapkan',
            'dikirim' => 'Sedang Diantar',
            'selesai' => 'Selesai',
            'dibatalkan' => 'Dibatalkan',
            default => $this->status,
        };
    }

    public function getTimelineAttribute(): array
    {
        return [
            'pending' => 'Menunggu',
            'diterima' => 'Diterima',
            'disiapkan' => 'Disiapkan',
            'dikirim' => 'Dikirim',
            'selesai' => 'Selesai',
            'dibatalkan' => 'Dibatalkan',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
