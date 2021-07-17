<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateColorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('colors', function (Blueprint $table) {
            $table->id();
            $table->string('hBgColor')->nullable();
            $table->string('hTxColor')->nullable();
            $table->string('hScColor')->nullable();
            $table->string('hTrColor')->nullable();
            $table->string('nvBgColor')->nullable();
            $table->string('nvTxColor')->nullable();
            $table->string('nvBrColor')->nullable();
            $table->string('fBgColor')->nullable();
            $table->string('fTxColor')->nullable();
            $table->string('sbBgColor')->nullable();
            $table->string('sbIcColor')->nullable();
            $table->string('sbScColor')->nullable();
            $table->string('sbTxColor')->nullable();
            $table->string('hmBgColor')->nullable();
            $table->string('hmTxColor')->nullable();
            $table->string('ctBgColor')->nullable();
            $table->string('ctTxColor')->nullable();
            $table->string('pPrColor')->nullable();
            $table->string('pIcColor')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('colors');
    }
}
