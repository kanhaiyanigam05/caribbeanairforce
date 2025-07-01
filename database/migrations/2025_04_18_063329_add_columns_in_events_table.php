<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->boolean('reserved')->default(false)->after('passes');
            $table->string('seating_map')->nullable()->after('reserved');
            $table->json('seating_plan')->nullable()->after('seating_map');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn(['reserved', 'seating_map', 'seating_plan']);
        });
    }
};