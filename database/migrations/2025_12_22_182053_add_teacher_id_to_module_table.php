<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // public function up(): void
    // {
    //     Schema::table('module', function (Blueprint $table) {
    //         //
    //     });
    // }

    // /**
    //  * Reverse the migrations.
    //  */
    // public function down(): void
    // {
    //     Schema::table('module', function (Blueprint $table) {
    //         //
    //     });
    // }

    public function up(): void
{
    Schema::table('modules', function (Blueprint $table) {
        $table->foreignId('teacher_id')
              ->nullable()
              ->constrained('users')
              ->onDelete('set null')
              ->after('active');
    });
}

public function down(): void
{
    Schema::table('modules', function (Blueprint $table) {
        $table->dropForeign(['teacher_id']);
        $table->dropColumn('teacher_id');
    });
}
};
