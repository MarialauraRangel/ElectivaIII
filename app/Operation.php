<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Operation extends Model
{
    protected $fillable = ['name', 'slug'];

    public function reports() {
        return $this->belongsToMany(Report::class)->withTimestamps();
    }
}
