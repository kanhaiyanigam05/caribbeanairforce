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
        Schema::create('mail_lists', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
        Schema::create('mail_list_subscribers', function (Blueprint $table) {
            $table->unsignedBigInteger('subscriber_id')->nullable();
            $table->foreign('subscriber_id')->references('id')->on('users')->cascadeOnDelete();
            $table->unsignedBigInteger('list_id')->nullable();
            $table->foreign('list_id')->references('id')->on('mail_lists')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mail_list_subscribers');
        Schema::dropIfExists('mail_lists');
    }
};