<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('profile_photo')->nullable();
            $table->string('profile_fullname')->nullable();
            $table->string('profile_specialization')->nullable();
            $table->string('profile_email')->nullable();
            $table->string('telegram_profile')->nullable();
            $table->string('telegram_api_key')->nullable();
            $table->string('whatsapp_number')->nullable();
            $table->string('whatsapp_api_key')->nullable();
            $table->string('gmail_account')->nullable();
            $table->string('bulk_sms_name')->nullable();
            $table->string('bulk_sms_number')->nullable();
            $table->string('bulk_sms_api_key')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
