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
        Schema::create('event_categories', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->text('description')->nullable();
            $table->boolean('status')->nullable();
            $table->timestamps();
        });
        Schema::table('events', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id')->nullable()->after('slug');
            $table->foreign('category_id')->references('id')->on('event_categories')->onDelete('set null');
            $table->enum('type', ['ticket', 'pass'])->default('ticket')->after('organizer_phone');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropColumn(['category_id', 'type']);
        });
        Schema::dropIfExists('event_categories');
    }
};