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

        Schema::table('sops', function (Blueprint $table) {
            if (!Schema::hasColumn('sops', 'archived_by')) {
                $table->integer('archived_by')->nullable();
            }

            if (!Schema::hasColumn('sops', 'archived_at')) {
                $table->timestamp('archived_at')->nullable();
            }
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('sops')) {
            return;
        }

        Schema::table('sops', function (Blueprint $table) {
            if (Schema::hasColumn('sops', 'archived_by')) {
                $table->dropColumn('archived_by');
            }

            if (Schema::hasColumn('sops', 'archived_at')) {
                $table->dropColumn('archived_at');
            }
        });
    }
};