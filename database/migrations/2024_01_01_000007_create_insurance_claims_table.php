<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('insurance_claims', function (Blueprint $table) {
            $table->id();
            $table->string('claim_id')->unique();
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->foreignId('facility_id')->constrained('healthcare_facilities')->onDelete('cascade');
            $table->date('claim_date');
            $table->date('service_date');
            $table->decimal('claim_amount', 12, 2);
            $table->decimal('approved_amount', 12, 2)->nullable();
            $table->enum('claim_status', ['draft', 'submitted', 'under_review', 'approved', 'rejected', 'paid'])->default('draft');
            $table->text('service_description');
            $table->foreignId('medical_record_id')->nullable()->constrained('medical_records')->onDelete('set null');
            $table->string('submitted_by')->nullable();
            $table->string('reviewed_by')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->timestamps();

            $table->index('claim_id');
            $table->index('patient_id');
            $table->index('claim_status');
            $table->index('claim_date');
        });
    }

    public function down()
    {
        Schema::dropIfExists('insurance_claims');
    }
};
