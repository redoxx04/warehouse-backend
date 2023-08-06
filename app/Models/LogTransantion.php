<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class LogTransantion extends Model
{
    use HasFactory;

    protected $table = 'log_transantions';

    public $timestamps = true;

    protected $fillable = [
        'id_log_transaction',
        'id_invoice',
        'id_produk',
        'jumlah_produk',
        'total_harga_produk',
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

    public function log_invoice()
    {
        return $this->belongsTo('App\Models\LogInvoice', 'id_invoice');
    }

    public function produk()
    {
        return $this->belongsTo('App\Models\Product', 'id_produk');
    }
}
