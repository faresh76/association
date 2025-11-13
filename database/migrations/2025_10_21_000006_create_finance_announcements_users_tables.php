<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        /**
         * 5. FINANCE & DONATIONS
         */
Schema::create('donations', function (Blueprint $table) {
    $table->id('donation_id');
    $table->string('donor_name', 100);
    $table->unsignedBigInteger('member_id')->nullable();
    $table->foreign('member_id')->references('member_id')->on('members')->onDelete('set null');
    $table->decimal('amount', 10, 2);
    $table->dateTime('donation_date')->default(DB::raw('CURRENT_TIMESTAMP'));
    $table->string('purpose', 100)->nullable();
    $table->timestamps();
});

        /**
         * 6. ANNOUNCEMENTS
         */
        Schema::create('announcements', function (Blueprint $table) {
            $table->id('announcement_id');
            $table->string('title', 100);
            $table->text('content')->nullable();
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamp('created_at')->useCurrent();
        });

        /**
         * 7. USERS & AUTHENTICATION (using Laravel default + Spatie)
         * Skip default users table (Laravel provides it)
         */

        // Roles & Permissions handled by Spatie
        // These will be created by Spatie’s own migrations:
        // - roles
        // - permissions
        // - model_has_roles
        // - model_has_permissions
        // - role_has_permissions

        /**
         * 8. USER SESSIONS
         */
        Schema::create('user_sessions', function (Blueprint $table) {
            $table->id('session_id');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->dateTime('login_time')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime('logout_time')->nullable();
            $table->string('ip_address', 50)->nullable();
            $table->text('user_agent')->nullable();
        });

        /**
         * 9. ACTIVITY LOGS
         */
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id('log_id');
            $table->string('user_action', 255);
            $table->foreignId('performed_by')->constrained('users')->onDelete('cascade');
            $table->dateTime('performed_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
        Schema::dropIfExists('user_sessions');
        Schema::dropIfExists('announcements');
        Schema::dropIfExists('donations');
    }
};
