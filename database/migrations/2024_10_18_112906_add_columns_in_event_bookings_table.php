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
        Schema::table('event_bookings', function (Blueprint $table) {
            $table->string('fname')->nullable()->after('user_id');
            $table->string('lname')->nullable()->after('fname');
            $table->string('email')->nullable()->after('lname');
            $table->string('phone')->nullable()->after('email');
            $table->unsignedBigInteger('tickets')->nullable()->after('phone');
            $table->decimal('price', 10, 2)->nullable()->after('tickets');
            $table->decimal('total', 10, 2)->nullable()->after('price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('event_bookings', function (Blueprint $table) {
            $table->dropColumn(['fname', 'lname', 'email', 'phone', 'phone', 'tickets', 'price', 'total']);
        });
    }
};
