<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasColumn('debts', 'status')) {
            Schema::table('debts', function (Blueprint $table) {
                $table->string('status')->default('unpaid')->after('amount');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('debts', 'status')) {
            Schema::table('debts', function (Blueprint $table) {
                $table->dropColumn('status');
            });
        }
    }
};
