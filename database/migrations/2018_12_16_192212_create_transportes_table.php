<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransportesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::dropIfExists('transportes');

      Schema::create('transportes', function (Blueprint $table) {
        $table->increments('id');
        $table->string('rif')->nullable();
        $table->string('nombre');
        $table->string('direccion')->nullable();
        $table->integer('created_by')->nullable();
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
      Schema::dropIfExists('transportes');
    }
  }
