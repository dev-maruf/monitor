<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $fillable = ['name', 'key'];

    public function data()
    {
        return $this->hasMany('App\Data');
    }
}
