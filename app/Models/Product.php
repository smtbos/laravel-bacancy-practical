<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'user_id',
        'name'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            if (!$product->user_id)
                $product->user_id = auth()->user()->id;
        });
    }

    /**
     * Get the user that owns the product.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the product lots for the product.
     */
    public function lots()
    {
        return $this->hasMany(ProductLot::class);
    }

    /**
     * Scope a query to get products with less stock.
     */
    public function scopeLessStock($query)
    {
        $stock = config('constants.product.notification.less_stock_quantity');

        return $query->withSum('lots', 'quantity')
            ->having('lots_sum_quantity', '<',  $stock);
    }
}
