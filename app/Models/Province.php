<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    protected $table = 'provinces';
    protected $primaryKey = 'province_id';
    protected $fillable = ['province_name', 'province_code'];

    public function getRouteKeyName()
    {
        return 'province_id';
    }

    public function cities()
    {
        return $this->hasMany(City::class, 'province_id', 'province_id');
    }
}
