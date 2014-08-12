<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateInvoiceProductTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'invoice_product',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('invoice_id'); // yyyymm-000000
                $table->integer('product_id');
                $table->integer('quantity');
                $table->decimal('price', 12, 2);
                $table->decimal('total', 12, 2);
                $table->string('fee_type'); // amount, percentage
                $table->decimal('fee', 12, 2);
                $table->decimal('total_fee', 12, 2);
                $table->timestamps();
            }
        );
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('invoice_product');
    }

}
