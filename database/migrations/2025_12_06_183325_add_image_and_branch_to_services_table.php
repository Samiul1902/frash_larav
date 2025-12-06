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
        Schema::table('services', function (Blueprint $table) {
            if (!Schema::hasColumn('services', 'image')) {
                $table->string('image')->nullable()->after('description');
            }
            if (!Schema::hasColumn('services', 'branch_id')) {
                $table->foreignId('branch_id')->nullable()->after('image')->constrained('branches')->nullOnDelete();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn('image');
            $table->dropForeign(['branch_id']);
            $table->dropColumn('branch_id');
        });
    }
};
