<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $table = 'districts';
    protected $primaryKey = 'district_id';
    protected $fillable = ['district_name', 'district_code', 'city_id'];

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id', 'city_id');
    }
}
