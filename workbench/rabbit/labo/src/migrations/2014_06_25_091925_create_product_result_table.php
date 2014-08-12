<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductResultTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'product_result',
            function (Blueprint $table) {
                $table->increments('id');
                $table->integer('product_id'); // foreign key of product table
                $table->string('kh_name');
                $table->string('en_name');
                $table->string('normal_value');
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
        Schema::drop('product_result');
    }

    /**
     * Product Result Table Seeder
     */
    private function seeder()
    {
        DB::table('product_result')->insert(
            array(
                array(
                    'product_id' => 3,
                    'kh_name' => 'HG sub item 1',
                    'en_name' => 'HG sub item 1',
                    'normal_value' => '100-500',
                    'created_at' => new DateTime(),
                    'updated_at' => new DateTime(),
                ),
                array(
                    'product_id' => 3,
                    'kh_name' => 'HG sub item 2',
                    'en_name' => 'HG sub item 2',
                    'normal_value' => '100-500',
                    'created_at' => new DateTime(),
                    'updated_at' => new DateTime(),
                ),
                array(
                    'product_id' => 3,
                    'kh_name' => 'HG sub item 3',
                    'en_name' => 'HG sub item 3',
                    'normal_value' => '100-500',
                    'created_at' => new DateTime(),
                    'updated_at' => new DateTime(),
                ),
            )
        );
    }
}
