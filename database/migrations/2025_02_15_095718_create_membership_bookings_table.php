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
        Schema::create('membership_bookings', function (Blueprint $table) {
            $table->id();
            $table->string('membership_number')->nullable();
            $table->unsignedBigInteger('membership_id')->nullable();
            $table->foreign('membership_id')->references('id')->on('memberships')->cascadeOnDelete();
            $table->string('fname')->nullable();
            $table->string('lname')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('transaction_id')->nullable();
            $table->decimal('amount', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('membership_bookings');
    }
};
