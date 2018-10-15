<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientTrackingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_tracking', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('client_id');
            $table->point('coordinates');
            $table->timestamps();

            $table->foreign('client_id', 'client_id_fk')
                ->references('id')
                ->on('client')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->spatialIndex('coordinates', 'coordinates_idx');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('client_tracking', function (Blueprint $table) {
            $table->dropForeign('client_id_fk');
            $table->dropSpatialIndex('coordinates_idx');
            $table->drop();
        });
    }
}
