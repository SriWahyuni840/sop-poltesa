<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::table('sops', function (Blueprint $table) {
        $table->integer('archived_by')->nullable();
        $table->timestamp('archived_at')->nullable();
    });
}

public function down()
{
    Schema::table('sops', function (Blueprint $table) {
        $table->dropColumn(['archived_by', 'archived_at']);
    });
}
};
