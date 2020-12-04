<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Disease extends Model
{
    protected $fillable = ['name', 'slug'];

    public function report_diseases()
    {
        return $this->hasMany(DiseaseReport::class);
    }

    public function report_familiars()
    {
        return $this->hasMany(FamiliarReport::class, 'disease_id');
    }
}
