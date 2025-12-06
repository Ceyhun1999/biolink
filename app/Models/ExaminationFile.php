<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExaminationFile extends Model
{
    protected $fillable = [
        'examination_id', 'file_path', 'file_name', 'mime_type', 'file_size', 'file_type'
    ];

    public function examination() {
        return $this->belongsTo(Examination::class);
    }
}
