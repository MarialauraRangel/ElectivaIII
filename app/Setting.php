<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['about', 'terms', 'privacity', 'map', 'facebook', 'twitter', 'instagram', 'phone', 'email', 'address', 'discount', 'banner'];
}
