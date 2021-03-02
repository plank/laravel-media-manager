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
        if (!Schema::hasColumns('media', $adding) && !Schema::hasColumns('media_translations', $adding)) {
            Schema::table('media', function (Blueprint $table) {
                $table->string('title')->nullable();
                $table->text('caption')->nullable();
                $table->string('alt')->nullable();
                $table->string('credit')->nullable();
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
