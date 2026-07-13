<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('employee_id')->nullable()->unique();
            $table->string('department')->nullable();
            $table->foreignId('facility_id')->nullable()->constrained('healthcare_facilities')->onDelete('set null');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('status', ['active', 'inactive', 'suspended'])->default('active');
            $table->rememberToken();
            $table->timestamps();

            $table->index('facility_id');
            $table->index('email');
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
};
