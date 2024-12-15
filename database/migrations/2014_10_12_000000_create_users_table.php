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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('image_ktp');
            $table->string('phone_number');
            $table->string('emergency_phone');
            $table->string('image_selfie');
            $table->string('job');
            $table->enum('long_stay', ['3 Bulan', '6 Bulan', '1 Tahun', 'Lebih dari 1 Tahun'])->default('3 Bulan');
            $table->integer('amount_dp');
            $table->string('image_dp');
            $table->enum('role', ['admin', 'user']);
            $table->enum('aggrement', [true, false]);
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
