<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatientSource extends Model
{
    protected $fillable = [
        'name',
    ];

    public function patients() {
          return $this->hasMany(Patient::class);
    }
}
