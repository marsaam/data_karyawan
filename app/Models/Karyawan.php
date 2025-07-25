<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    use HasFactory;
    protected $table = 'karyawans';
    protected $guarded = [];

    public function pendidikans()
    {
        return $this->hasMany(Pendidikan::class);
    }

      public function keluargas()
    {
        return $this->hasMany(Keluarga::class);
    }

}
