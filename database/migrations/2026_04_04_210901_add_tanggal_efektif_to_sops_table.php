<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('sops')) {
            return;
        }

        if (!Schema::hasColumn('sops', 'tanggal_efektif')) {
            Schema::table('sops', function (Blueprint $table) {
                $table->date('tanggal_efektif')->nullable();
            });
        }
    }

    public function down(): void
    {
        if (!Schema::hasTable('sops')) {
            return;
        }

        if (Schema::hasColumn('sops', 'tanggal_efektif')) {
            Schema::table('sops', function (Blueprint $table) {
                $table->dropColumn('tanggal_efektif');
            });
        }
    }
};