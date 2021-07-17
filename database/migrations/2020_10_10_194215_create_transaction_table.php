<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction', function (Blueprint $table) {
            $table->id();
            $table->string("id_transaccion"); //x_transaction_id
            $table->string("tipo")->nullable(); //x_type_payment
            $table->string("status")->nullable(); //x_cod_transaction_state
            $table->string("error")->nullable(); //x_errorcode
            $table->string("respuesta_text")->nullable(); //x_transaction_state
            $table->integer("customer_id"); //id de cliente en orden
            $table->string("customer_name")->nullable(); //x_extra1
            $table->string("cliente")->nullable(); //x_cust_id_cliente
            $table->string("factura")->nullable(); //x_id_factura
            $table->string("franquicia")->nullable(); //x_franchise
            $table->string("banco")->nullable(); //x_bank_name
            $table->string("tarjeta")->nullable(); //x_cardnumber
            $table->string("moneda")->nullable(); //x_currency_code
            $table->string("monto")->nullable(); //x_amount
            $table->string("ip")->nullable(); //x_customer_ip
            $table->string("medio")->nullable(); //Tipo de Pago
            $table->string("fecha_transaccion")->nullable(); //x_fecha_transaccion
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
        Schema::dropIfExists('transaction');
    }
}
