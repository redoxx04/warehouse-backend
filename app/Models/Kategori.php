<?php

namespace App\Models;

use App\Models\subKategori;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_kategori';

    protected $table = 'kategori';

    public $fillable = [
        'nama_kategori',
        'kode_kategori',
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

    public function subKategoris()
    {
        return $this->hasMany(subKategori::class, 'id_kategori');
    }

    public function products()
    {
        return $this->hasMany('App\Models\Product');
    }
}
