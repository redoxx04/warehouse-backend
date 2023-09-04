<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class subKategori extends Model
{
    // use HasFactory;

    public $table = 'sub_kategori';
    protected $primaryKey = 'id_sub_kategori';

    public $timestamps = true;

    protected $fillable = [
        'id_sub_kategori',
        'id_kategori',
        'nama_sub_kategori',
        'kode_sub_kategori',
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

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }

    public function products() {
        return $this->hasMany(Product::class);
    }
}
