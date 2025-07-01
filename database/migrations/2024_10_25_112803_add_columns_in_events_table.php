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
            $table->string('meta_title')->nullable()->after('organizer_id');
            $table->string('meta_keywords')->nullable()->after('meta_title');
            $table->longText('meta_description')->nullable()->after('meta_keywords');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn(['meta_title', 'meta_keywords', 'meta_description']);
        });
    }
};
