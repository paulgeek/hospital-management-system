<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->string('appointment_id')->unique();
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->foreignId('provider_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('facility_id')->constrained('healthcare_facilities')->onDelete('cascade');
            $table->date('appointment_date');
            $table->time('appointment_time');
            $table->string('department');
            $table->text('reason')->nullable();
            $table->enum('status', ['scheduled', 'completed', 'cancelled', 'no-show', 'rescheduled'])->default('scheduled');
            $table->text('notes')->nullable();
            $table->boolean('reminder_sent')->default(false);
            $table->timestamps();

            $table->index('appointment_id');
            $table->index('patient_id');
            $table->index('facility_id');
            $table->index('appointment_date');
            $table->index('status');
        });
    }

    public function down()
    {
        Schema::dropIfExists('appointments');
    }
};
