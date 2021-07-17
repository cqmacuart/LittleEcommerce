<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->string("nombre");
            $table->string("short_des")->nullable();
            $table->longText("long_des")->nullable();
            $table->integer("estado_id")->index();
            $table->integer("category_id")->index();
            $table->integer("position")->default(1);
            $table->decimal("price", 8, 2, true)->default(0);
            $table->string("image")->nullable();
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
        Schema::dropIfExists('products');
    }
}
