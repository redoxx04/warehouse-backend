<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Kategori extends Model
{
    use HasFactory;

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

    public function products()
    {
        return $this->hasMany('App\Models\Product');
    }
}
