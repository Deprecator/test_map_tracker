<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('city', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 255);
            $table->unsignedInteger('country_id');
            $table->point('coordinates');
            $table->timestamps();

            $table->foreign('country_id', 'country_id_fk')
                ->references('id')
                ->on('country')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('city', function (Blueprint $table) {
            $table->dropForeign('country_id_fk');
            $table->drop();
        });
    }
}
