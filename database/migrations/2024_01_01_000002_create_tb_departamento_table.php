<?php

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
        Schema::create('tb_departamento', function (Blueprint $table) {
            $table->increments('depa_codi');
            $table->string('depa_nomb', 50);
            $table->string('pais_codi', 3);

            $table->foreign('pais_codi')
                ->references('pais_codi')->on('tb_pais')
                ->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_departamento');
    }
};
