<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableInvoiceProduct extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_product', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('invoice_id')->unsigned();
            $table->string('name');
            $table->decimal('price');
            $table->integer('qty');
            $table->decimal('total');
            $table->timestamps();
        });

        Schema::table('invoice_product', function (Blueprint $table) {
            $table->foreign('invoice_id')
                  ->references('id')
                  ->on('invoice')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');            
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoice_product');
    }
}
