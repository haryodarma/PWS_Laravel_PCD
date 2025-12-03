<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table = 'cities';
    protected $primaryKey = 'city_id';
    protected $fillable = ['city_name', 'city_code', 'province_id'];

    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id', 'province_id');
    }

    public function districts()
    {
        return $this->hasMany(District::class, 'city_id', 'city_id');
    }
}
