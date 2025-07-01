<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->text('venue_map')->nullable()->after('address');
            $table->text('ticket_location_map')->nullable()->after('ticket_location');
        });
    }

    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn(['venue_map', 'ticket_location_map']);
        });
    }
};
