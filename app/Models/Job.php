<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory, HasUuids;

    protected $guarded = ['id'];
    protected $primaryKey = 'id';
    public $incrementing = false;
}
