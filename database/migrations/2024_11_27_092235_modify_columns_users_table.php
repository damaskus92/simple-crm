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
            $table->string('name')
                ->nullable()
                ->unique()
                ->change();
            $table->after('password', function (Blueprint $table) {
                $table->foreignId('role_id')
                    ->nullable()
                    ->constrained('roles')
                    ->nullOnDelete();
            });
            $table->after('updated_at', function (Blueprint $table) {
                $table->softDeletes();
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique(['name']);
            $table->after('id', function (Blueprint $table) {
                $table->string('name')
                    ->nullable(false)
                    ->change();
            });
            $table->dropForeign(['role_id']);
            $table->dropColumn('role_id');
            $table->dropSoftDeletes();
        });
    }
};
