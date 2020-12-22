<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Municipality extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'state_id'];

    public function state() {
        return $this->belongsTo(State::class);
    }

    public function locations() {
        return $this->hasMany(Location::class);
    }
}
