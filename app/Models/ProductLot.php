<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductLot extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
        'expiry_date',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($productLot) {
            if (!$productLot->user_id)
                $productLot->user_id = auth()->user()->id;
        });
    }

    /**
     * Get the user that owns the product lot.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the product that owns the product lot.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the expiry date formated.
     */
    public function getExpiryDateFormatedAttribute()
    {
        return Carbon::parse($this->expiry_date)->format('d-m-Y');
    }

    /**
     * Scope a query to get lots expiring in next days.
     */
    public function scopeExpiringInNextDays($query)
    {
        $days = config('constants.product.notification.expiry_days');

        $sendExpiryForNotifiedLots = config('constants.product.notification.send_expiry_for_notified_lots');
        if ($sendExpiryForNotifiedLots) {
            return $query->whereBetween('expiry_date', [Carbon::tomorrow()->format('Y-m-d'), Carbon::now()->addDays($days)->format('Y-m-d')]);
        } else {
            return $query->where('expiry_date',  Carbon::now()->addDays($days)->format('Y-m-d'));
        }
    }
}
