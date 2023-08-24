<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    // Table Name
    protected $table = 'carts';

    // Primary Key Field
    protected $primaryKey = 'id_cart';

    // Fillable attributes
    protected $fillable = [
        'id_user',
        'id_produk',
        'jumlah_produk_invoice',
        // Add any other fields you want to be mass assignable
    ];

    /**
     * Get the user associated with the cart.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    /**
     * Get the product associated with the cart.
     */
    public function products() {
        return $this->belongsTo(Product::class, 'id_produk');
    }

    public function getCreatedAtAttribute()
    {
        if (!is_null($this->attributes['created_at'])) {
            return Carbon::parse($this->attributes['created_at'])->format('Y-m-d H:i:s');
        }
    }

    public function getUpdatedAtAttribute()
    {
        if (!is_null($this->attributes['updated_at'])) {
            return Carbon::parse($this->attributes['updated_at'])->format('Y-m-d H:i:s');
        }
    }
}
