<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $adding = ['title', 'caption', 'alt', 'credit'];
        if (!Schema::hasColumns(config('media-manager.table'), $adding)) {
            Schema::table('media', function (Blueprint $table) {
                $table->string('source')->nullable()->after('id');
                $table->string('credit')->nullable()->after('id');
                $table->string('alt')->nullable()->after('id');
                $table->text('caption')->nullable()->after('id');
                $table->string('title')->nullable()->after('id');
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
        // Down will be handled when tables are removed.
    }
}
