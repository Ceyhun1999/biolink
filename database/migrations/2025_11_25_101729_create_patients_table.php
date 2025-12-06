<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('firstName');
            $table->string('lastName');
            $table->string('fatherName')->nullable();
            $table->enum('gender', ['Kişi', 'Qadın'])->nullable();
            $table->foreignId('patient_source_id')->nullable()->constrained()->nullOnDelete();
            $table->date('birthday')->nullable();
            $table->string('phone')->nullable();
            $table->string('phone2')->nullable();
            $table->string('diagnose')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
