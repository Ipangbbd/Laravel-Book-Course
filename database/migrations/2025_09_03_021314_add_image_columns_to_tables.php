<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add gambar to users table atau connect relasi foto ke users table
        Schema::table('users', function (Blueprint $table) {
            $table->string('avatar_path')->nullable()->after('status');
        });

        // Add gambar to courses table atau connect relasi foto ke courses table
        Schema::table('courses', function (Blueprint $table) {
            $table->string('image_path')->nullable()->after('max_participants');
        });

        // Add payment bukti and verifikasi to payments table atau connect relasi ke payments table
        Schema::table('payments', function (Blueprint $table) {
            $table->string('proof_path')->nullable()->after('amount');
            $table->timestamp('verified_at')->nullable()->after('paid_at');
            $table->foreignId('verified_by')->nullable()->constrained('users')->nullOnDelete()->after('verified_at');
            $table->text('admin_notes')->nullable()->after('verified_by');
            $table->text('rejection_reason')->nullable()->after('admin_notes');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('avatar_path');
        });

        Schema::table('courses', function (Blueprint $table) {
            $table->dropColumn('image_path');
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn(['proof_path', 'verified_at', 'admin_notes', 'rejection_reason']);
            $table->dropConstrainedForeignId('verified_by');
        });
    }
};