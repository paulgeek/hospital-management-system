<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('nhis_memberships', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->unique()->constrained('patients')->onDelete('cascade');
            $table->string('nhis_number')->unique();
            $table->enum('member_category', ['Vulnerable', 'Indigent', 'SSNIT', 'Private', 'Informal'])->default('Private');
            $table->date('registration_date');
            $table->date('expiry_date');
            $table->enum('subscription_status', ['active', 'inactive', 'suspended', 'expired'])->default('active');
            $table->decimal('premium_paid', 10, 2)->default(0);
            $table->enum('payment_method', ['Cash', 'Check', 'Bank Transfer', 'Mobile Money', 'Insurance'])->nullable();
            $table->date('renewal_date')->nullable();
            $table->boolean('exemption_status')->default(false);
            $table->string('exemption_reason')->nullable();
            $table->timestamps();

            $table->index('nhis_number');
            $table->index('subscription_status');
            $table->index('expiry_date');
        });
    }

    public function down()
    {
        Schema::dropIfExists('nhis_memberships');
    }
};
