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
        Schema::create('tb_pais', function (Blueprint $table) {
            $table->string('pais_codi', 3)->primary();
            $table->string('pais_nomb', 50);
            // Código del municipio capital. Sin llave foránea porque
            // tb_municipio depende (indirectamente) de esta tabla.
            $table->unsignedInteger('pais_capi')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_pais');
    }
};
