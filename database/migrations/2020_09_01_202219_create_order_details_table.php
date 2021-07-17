<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_details', function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->integer("order_id")->index();
            $table->string("order_pedido");
            $table->integer("product_id")->index();
            $table->integer("quantity")->default(0);
            $table->decimal("unit_price", 8, 2, false)->default(0);
            $table->decimal("total_price", 20, 2, false)->default(0);
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
        Schema::dropIfExists('order_details');
    }
}
