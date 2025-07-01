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
            $table->string('banner')->nullable()->after('slug');
            $table->json('faqs')->nullable()->after('meta_description');
            $table->bigInteger('free_tickets')->nullable()->after('quantity');
            $table->bigInteger('donated_tickets')->nullable()->after('free_tickets');
            $table->bigInteger('paid_tickets')->nullable()->after('donated_tickets');
            $table->bigInteger('total_tickets')->nullable()->after('paid_tickets');
            $table->json('packages')->nullable()->after('total_tickets');
            $table->dropColumn(['price', 'quantity']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn(['banner', 'faqs', 'free_tickets', 'donated_tickets', 'paid_tickets', 'total_tickets', 'paid_slots']);
            $table->bigInteger('price')->nullable()->after('ticket_location');
            $table->bigInteger('quantity')->nullable()->after('price');
        });
    }
};
