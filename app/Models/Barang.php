<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'barangs';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    public $incrementing = 'false';

    public function suplier()
    {
        return $this->belongsTo(Suplier::class);
    }

    public function reports()
    {
        return $this->hasMany(Report::class, 'kode_barang', 'kode_barang');
    }

    protected static function boot(){
        parent::boot();

        // Fungsi untuk update kode_barang ke detail_penjualan dan pembelian
        static::updating(function ($barang){
            if($barang->isDirty('kode_barang')){
                DetailPenjualan::where('kode_barang', $barang->getOriginal('kode_barang'))
                    ->update(['kode_barang' => $barang->kode_barang]);
                
                DetailPembelian::where('kode_barang', $barang->getOriginal('kode_barang'))
                    ->update(['kode_barang' => $barang->kode_barang]);
                
            }
        });
    }
}
