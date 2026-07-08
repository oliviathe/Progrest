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
            // avatar may already exist via the Google auth migration; only add if missing
            if (! Schema::hasColumn('users', 'avatar')) {
                $table->string('avatar')->nullable()->after('email');
            }

            if (! Schema::hasColumn('users', 'banner')) {
                $table->string('banner')->nullable()->after('avatar');
            }

            if (! Schema::hasColumn('users', 'about')) {
                $table->text('about')->nullable()->after('banner');
            }

            if (! Schema::hasColumn('users', 'linkedin')) {
                $table->string('linkedin')->nullable()->after('about');
            }

            if (! Schema::hasColumn('users', 'hide_email')) {
                $table->boolean('hide_email')->default(false)->after('linkedin');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            foreach (['banner', 'about', 'linkedin', 'hide_email'] as $column) {
                if (Schema::hasColumn('users', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
