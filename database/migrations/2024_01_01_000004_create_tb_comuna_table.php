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
        Schema::create('tb_comuna', function (Blueprint $table) {
            $table->increments('comu_codi');
            $table->string('comu_nomb', 50);
            $table->unsignedInteger('muni_codi');

            $table->foreign('muni_codi')
                ->references('muni_codi')->on('tb_municipio')
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
        Schema::dropIfExists('tb_comuna');
    }
};
