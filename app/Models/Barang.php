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

    public function suplier(){
        return $this->belongsTo(Suplier::class);
    }
}
