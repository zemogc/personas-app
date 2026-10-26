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
        Schema::create('tb_municipio', function (Blueprint $table) {
            $table->increments('muni_codi');
            $table->string('muni_nomb', 50);
            $table->unsignedInteger('depa_codi');

            $table->foreign('depa_codi')
                ->references('depa_codi')->on('tb_departamento')
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
        Schema::dropIfExists('tb_municipio');
    }
};
