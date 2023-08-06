<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class LogInvoicesModel extends Model
{
    protected $table = 'log_invoices';

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

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'id_user');
    }
}
