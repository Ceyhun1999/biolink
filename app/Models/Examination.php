<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Examination extends Model
{
    protected $fillable = [
        'patient_id',
        'notes'
    ];

    public function patient()
    {
        return  $this->belongsTo(Patient::class);
    }

    public function files() {
        return $this->hasMany(ExaminationFile::class);
    }
}
