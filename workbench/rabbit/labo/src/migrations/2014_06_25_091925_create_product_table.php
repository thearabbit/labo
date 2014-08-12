<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'product',
            function (Blueprint $table) {
                $table->increments('id');
                $table->integer('category_id'); // foreign key of category
                $table->string('kh_name');
                $table->string('en_name');
                $table->string('normal_value');
                $table->decimal('price', 12, 2);
                $table->string('fee_type'); // amount, percentage
                $table->decimal('fee', 12, 2);
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
        Schema::drop('product');
    }

    /**
     * Product Table Seeder
     */
    private function seeder()
    {
        DB::table('product')->insert(
            array(
                array(
                    'category_id' => 1,
                    'kh_name' => 'Réticulocyles',
                    'en_name' => 'Réticulocyles',
                    'normal_value' => '100-500',
                    'price' => 5000,
                    'fee_type' => 'percentage', // amount, percentage
                    'fee' => 5,
                    'created_at' => new DateTime(),
                    'updated_at' => new DateTime(),
                ),
                array(
                    'category_id' => 1,
                    'kh_name' => 'VS',
                    'en_name' => 'VS',
                    'normal_value' => '100-500',
                    'price' => 8000,
                    'fee_type' => 'amount', // amount, percentage
                    'fee' => 1000,
                    'created_at' => new DateTime(),
                    'updated_at' => new DateTime(),
                ),
                // Product has result item
                array(
                    'category_id' => 1,
                    'kh_name' => 'HG',
                    'en_name' => 'HG',
                    'normal_value' => '',
                    'price' => 7000,
                    'fee_type' => 'percentage', // amount, percentage
                    'fee' => 5,
                    'created_at' => new DateTime(),
                    'updated_at' => new DateTime(),
                ),
                array(
                    'category_id' => 2,
                    'kh_name' => 'Urine Machine+Culot',
                    'en_name' => 'Urine Machine+Culot',
                    'normal_value' => '100-500',
                    'price' => 6000,
                    'fee_type' => 'percentage', // amount, percentage
                    'fee' => 5,
                    'created_at' => new DateTime(),
                    'updated_at' => new DateTime(),
                ),
            )
        );
    }

}
