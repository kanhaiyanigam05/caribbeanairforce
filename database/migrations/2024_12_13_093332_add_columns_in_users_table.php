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
        Schema::table('users', function (Blueprint $table) {
            $table->string('company_name')->nullable()->after('address');
            $table->string('license_number')->nullable()->after('company_name');
            $table->json('license_file')->nullable()->after('license_number');
            $table->enum('license_status', ['pending', 'accepted', 'rejected'])->default('pending')->after('license_file');
            $table->enum('address_proof', ['utility_bill', 'bank_statement', 'passport'])->nullable()->after('license_status');
            $table->string('address_proof_number')->nullable()->after('address_proof');
            $table->json('address_proof_file')->nullable()->after('address_proof_number');
            $table->enum('address_proof_status', ['pending', 'accepted', 'rejected'])->default('pending')->after('address_proof_file');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['company_name', 'license_number', 'license_file', 'license_status', 'address_proof', 'address_proof_number', 'address_proof_file', 'address_proof_status']);
        });
    }
};
