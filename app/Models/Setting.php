<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'profile_photo',
        'profile_fullname',
        'profile_specialization',
        'profile_email',
        'telegram_profile',
        'telegram_api_key',
        'whatsapp_number',
        'whatsapp_api_key',
        'gmail_account',
        'bulk_sms_name',
        'bulk_sms_number',
        'bulk_sms_api_key',
    ];
}
