<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('event_bookings', function (Blueprint $table) {
            $table->dropColumn('price');
            $table->json('packages')->nullable()->after('tickets');
            $table->json('slots')->nullable()->after('packages');
        });
    }

    public function down(): void
    {
        Schema::table('event_bookings', function (Blueprint $table) {
            $table->dropColumn(['packages', 'slots']);
            $table->decimal('price', 10, 2)->nullable()->after('tickets');
        });
    }
};
