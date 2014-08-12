<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateInvoiceTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'invoice',
            function (Blueprint $table) {
                $table->string('id'); // yyyymm000000
                $table->dateTime('invoice_date')->default('0000-00-00 00:00:00');
                $table->integer('staff_id');
                $table->integer('agent_id');
                $table->integer('customer_id');
                $table->decimal('total', 12, 2);
                $table->decimal('fee_amount', 12, 2);
                $table->decimal('fee_per', 12, 2);
                $table->integer('exchange_id');
                $table->string('status'); // paid, unpaid, block
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
        Schema::drop('invoice');
    }

}
