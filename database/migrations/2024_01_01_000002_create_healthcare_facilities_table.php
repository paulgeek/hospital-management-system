<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('healthcare_facilities', function (Blueprint $table) {
            $table->id();
            $table->string('facility_code')->unique();
            $table->string('facility_name');
            $table->enum('facility_type', ['Hospital', 'Clinic', 'Pharmacy', 'Laboratory', 'Diagnostic Center']);
            $table->string('region');
            $table->string('district');
            $table->string('town');
            $table->text('address');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->boolean('nhis_accredited')->default(false);
            $table->string('accreditation_number')->nullable();
            $table->string('license_number')->nullable();
            $table->string('director_name')->nullable();
            $table->enum('status', ['active', 'inactive', 'suspended'])->default('active');
            $table->timestamps();

            $table->index('region');
            $table->index('district');
            $table->index('facility_type');
        });
    }

    public function down()
    {
        Schema::dropIfExists('healthcare_facilities');
    }
};
