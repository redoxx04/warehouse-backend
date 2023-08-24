<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class LogInvoice extends Model
{
    protected $table = 'log_invoices';

    protected $primaryKey = 'id_invoice';

    public $timestamps = true;

    protected $fillable = [
        'id_invoice',
        'nomor_invoice',
        'nama_invoice',
        'asal_transaksi',
        'contact_number',
        'address_invoice',
        'total_transaksi',
        'id_user',
    ];

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
    
    public function products(){
        return $this->belongsToMany(Product::class, 'log_transactions', 'id_invoice', 'id_produk')
                    ->withPivot('jumlah_produk_terbeli', 'total_harga_produk')
                    ->withTimestamps();
    }
    

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'id_user');
    }
}
