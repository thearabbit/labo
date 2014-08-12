<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCustomerTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'customer',
            function (Blueprint $table) {
                $table->increments('id');
                $table->string('kh_name');
                $table->string('en_name');
                $table->string('sex');
                $table->tinyInteger('age');
                $table->string('status');
                $table->text('address');
                $table->string('telephone');
                $table->string('email');
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
        Schema::drop('customer');
    }

    /**
     * Customer Table Seeder
     */
    private function seeder()
    {
        DB::table('customer')->insert(
            array(
                array(
                    'kh_name' => 'ទូទៅ',
                    'en_name' => 'General',
                    'sex' => 'M',
                    'age' => '55',
                    'status' => 'Married',
                    'address' => 'Battambang',
                    'telephone' => '',
                    'email' => '',
                    'created_at' => new DateTime(),
                    'updated_at' => new DateTime(),
                ),
                array(
                    'kh_name' => 'ចាន់វី',
                    'en_name' => 'Chanvy',
                    'sex' => 'F',
                    'age' => '65',
                    'status' => 'Single',
                    'address' => 'Battambang',
                    'telephone' => '',
                    'email' => '',
                    'created_at' => new DateTime(),
                    'updated_at' => new DateTime(),
                ),
            )
        );

    }
}
