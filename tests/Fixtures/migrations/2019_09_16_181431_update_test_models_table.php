<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTestModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('test_models', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->string('new_column')->nullable();
            $table->integer('type')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('test_models', function (Blueprint $table) {
            $table->string('name');
            $table->dropColumn('new_column');
            $table->string('type')->change();
        });
    }
}
