<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPenjualan extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'detail_penjualans';
    protected $guarded = ['id'];
    public $incrementing = false;

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'kode_barang', 'kode_barang')->orderBy('jenis');
    }
}
