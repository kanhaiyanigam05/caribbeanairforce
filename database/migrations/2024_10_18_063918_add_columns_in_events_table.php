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
        Schema::table('events', function (Blueprint $table) {
            //
            $table->enum('timing', ['daily', 'weekend', 'custom'])->nullable()->default('daily')->after('slug');
            $table->enum('ticket_mode', ['online', 'offline'])->nullable()->default('online')->after('city');
            $table->string('ticket_location')->nullable()->after('ticket_mode');
            $table->unsignedBigInteger('price')->nullable()->after('ticket_location');
            $table->unsignedBigInteger('quantity')->nullable()->after('price');
            $table->string('refund')->nullable()->after('quantity');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn(['timing', 'ticket_mode', 'ticket_location', 'price', 'quantity', 'refund']);
        });
    }
};
