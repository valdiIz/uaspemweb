<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function muatKelurahan()
    {
        return $this->belongsTo(Village::class, 'muat_kelurahan_id');
    }
    public function bongkarKelurahan()
    {
        return $this->belongsTo(Village::class, 'bongkar_kelurahan_id');
    }

    public function statuses()
    {
        return $this->belongsToMany(Status::class)->withPivot('tanggal');
    }
}
