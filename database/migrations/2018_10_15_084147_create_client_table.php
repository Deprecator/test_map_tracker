<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client', function (Blueprint $table) {
            $table->increments('id');
            $table->string('full_name', 50);
            $table->string('email', 30);
            $table->string('phone', 20);
            $table->unsignedInteger('city_id');
            $table->timestamps();

            $table->foreign('city_id', 'city_id_fk')
                ->references('id')
                ->on('city')
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
        Schema::table('client', function (Blueprint $table) {
            $table->dropForeign('city_id_fk');
            $table->drop();
        });
    }
}
