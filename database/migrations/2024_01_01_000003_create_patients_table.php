<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('patient_id')->unique();
            $table->string('first_name');
            $table->string('last_name');
            $table->date('date_of_birth');
            $table->enum('gender', ['Male', 'Female', 'Other']);
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('national_id')->nullable()->unique();
            $table->text('address')->nullable();
            $table->string('region')->nullable();
            $table->string('district')->nullable();
            $table->string('town')->nullable();
            $table->foreignId('facility_id')->constrained('healthcare_facilities');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('blood_type')->nullable();
            $table->text('allergy_information')->nullable();
            $table->string('emergency_contact')->nullable();
            $table->string('emergency_contact_phone')->nullable();
            $table->enum('status', ['active', 'inactive', 'transferred', 'deceased'])->default('active');
            $table->timestamps();

            $table->index('patient_id');
            $table->index('facility_id');
            $table->index('national_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('patients');
    }
};
