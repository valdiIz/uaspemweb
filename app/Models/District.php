<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;

    public function villages()
    {
        return $this->hasMany(Village::class);
    }

    public function regencies()
    {
        return $this->belongsTo(Regency::class);
    }
}
