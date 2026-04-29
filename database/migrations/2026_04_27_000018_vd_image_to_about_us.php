<?php
/**
 * Migration to add missing vd_image column to about_us table.
 * Fixed to resolve column "vd_image" does not exist error.
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('about_us')) {
            Schema::table('about_us', function (Blueprint $table) {
                if (!Schema::hasColumn('about_us', 'vd_image')) {
                    $table->string('vd_image')->nullable()->after('youtube_link');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('about_us')) {
            Schema::table('about_us', function (Blueprint $table) {
                if (Schema::hasColumn('about_us', 'vd_image')) {
                    $table->dropColumn('vd_image');
                }
            });
        }
    }
};
