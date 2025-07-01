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
            $table->string('organizer_name')->nullable()->after('organizer_id');
            $table->string('organizer_email')->nullable()->after('organizer_name');
            $table->string('organizer_phone')->nullable()->after('organizer_phone');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn(['organizer_name', 'organizer_email', 'organizer_phone']);
        });
    }
};