<?php

namespace App\Models;

use App\Mail\OrderCreated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Mail;

class Order extends Model
{
    use HasFactory;

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class)->withPivot('quantity', 'product_subtotal')->withTimestamps();
    }

    protected static function booted()
    {
        static::created(function ($order) {
            Mail::to(config('mail.order_recipient'))->queue(new OrderCreated($order));
        });
    }
}
