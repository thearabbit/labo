<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateExchangeTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'exchange',
            function (Blueprint $table) {
                $table->increments('id');
                $table->date('exchange_date')->default('0000-00-00');
                $table->decimal('usd', 12, 2);
                $table->decimal('khr', 12, 2);
                $table->decimal('thb', 12, 2);
                $table->text('des');
                $table->timestamps();
            }
        );

        // Call seeder
        $this->seeder();
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('exchange');
    }

    /**
     * Exchange Table Seeder
     */
    private function seeder()
    {
        DB::table('exchange')->insert(
            array(
                array(
                    'exchange_date' => '2014-07-01',
                    'usd' => 1,
                    'khr' => 4000,
                    'thb' => 30,
                    'created_at' => new DateTime(),
                    'updated_at' => new DateTime(),
                ),
            )
        );
    }

}
