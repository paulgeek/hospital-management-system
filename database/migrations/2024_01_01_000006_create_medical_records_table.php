<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('medical_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->foreignId('provider_id')->constrained('users')->onDelete('restrict');
            $table->foreignId('facility_id')->constrained('healthcare_facilities')->onDelete('cascade');
            $table->dateTime('record_date');
            $table->enum('visit_type', ['Consultation', 'Follow-up', 'Emergency', 'Admission', 'Discharge']);
            $table->text('diagnosis');
            $table->text('treatment_plan')->nullable();
            $table->json('medications')->nullable();
            $table->json('vital_signs')->nullable();
            $table->longText('notes')->nullable();
            $table->enum('status', ['draft', 'completed', 'signed', 'archived'])->default('draft');
            $table->timestamps();

            $table->index('patient_id');
            $table->index('facility_id');
            $table->index('record_date');
            $table->index('status');
        });
    }

    public function down()
    {
        Schema::dropIfExists('medical_records');
    }
};
