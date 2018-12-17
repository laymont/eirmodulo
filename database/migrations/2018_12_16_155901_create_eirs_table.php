<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEirsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('eirs');

        Schema::create('eirs', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('fecha');
            $table->integer('inventario_id');
            $table->enum('movimiento',['Ingreso','Relocalizacion','Salida']);
            $table->string('precintos')->nullable();
            $table->enum('imo',[0,1,2,3,4,5,6,7,8,9])->defaul(0);
            $table->string('dmgs')->nullable();
            $table->string('temperatura')->nullable();
            $table->string('observaciones')->nullable();
            $table->integer('transporte_id');
            $table->string('placa');
            $table->string('chofer');
            $table->string('identificacion');
            $table->integer('created_by');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('eirs');
    }
}
