<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $fillable = [
        'firstName',
        'lastName',
        'fatherName',
        'birthday',
        'phone',
        'phone2',
        'patient_source_id',
        'diagnose',
        'gender',
    ];

    public function patientSource()
    {
        return $this->belongsTo(PatientSource::class);
    }

    public function examinations()
    {
        return $this->hasMany(Examination::class);
    }


    public function getAgeAttribute(): ?int
    {
        if (!$this->birthday) {
            return null;
        }

        return Carbon::parse($this->birthday)->age;
    }
}
