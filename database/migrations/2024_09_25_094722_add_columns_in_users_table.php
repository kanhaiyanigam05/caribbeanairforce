<?php

use App\Models\User;
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
            $table->dropColumn('name');
            $table->string('fname')->nullable()->after('id');
            $table->string('lname')->nullable()->after('fname');
            $table->string('username')->nullable()->after('lname');
            $table->longText('profile')->nullable()->after('email');
            $table->longText('cover')->nullable()->after('profile');
            $table->string('city')->nullable()->after('remember_token');
            $table->text('address')->nullable()->after('city');
            $table->enum('role', ['admin', 'organizer', 'user'])->default('user')->after('address');
            $table->enum('status', ['active', 'inactive'])->default('active')->after('address');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('name')->nullable()->after('id');
            $table->dropColumn(['fname', 'lname', 'username', 'profile', 'cover', 'country', 'state', 'zipcode', 'address', 'role', 'status']);
        });
    }
};
