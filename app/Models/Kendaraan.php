<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Kendaraan extends Model
{
    use HasFactory;
    protected $connection = 'mongodb';
	protected $collection = 'kendaraan';

    protected $fillable = [
        'merk',
        'jenis',
        'tahun_relase',
        'mobil',
        'created_at',
    ];
}
