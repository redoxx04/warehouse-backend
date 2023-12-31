<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';
    
    protected $primaryKey = 'id_produk';

    public $timestamps = true;

    protected $fillable = [
        'id_produk',
        'kode_produk',
        'id_sub_kategori',
        'nama_produk',
        'harga_produk',
        'harga_modal',
        'jumlah_produk',
        'SKU_produk',
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

    public function invoices(){
        return $this->belongsToMany(LogInvoicesModel::class, 'log_transactions', 'id_produk', 'id_invoice')
                    ->withPivot('jumlah_produk_terbeli', 'total_harga_produk')
                    ->withTimestamps();
    }    

    public function sub_kategori()
    {
        return $this->belongsTo(subKategori::class, 'id_sub_kategori');
    }
}
