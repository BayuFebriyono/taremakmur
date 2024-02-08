<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeaderPembelian extends Model
{
    use HasFactory, HasUuids;

    protected $guarded = ['id'];
    protected $table = 'header_pembelians';
    public $incrementing = false;
}
