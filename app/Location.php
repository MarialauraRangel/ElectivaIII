<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Location extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'municipality_id'];

    public function municipality() {
        return $this->belongsTo(Municipality::class);
    }

    public function users() {
        return $this->hasMany(User::class);
    }

    public function deliveries() {
        return $this->hasMany(Delivery::class);
    }
}
