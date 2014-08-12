<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateStaffTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'staff',
            function (Blueprint $table) {
                $table->increments('id');
                $table->string('kh_name');
                $table->string('en_name');
                $table->string('sex');
                $table->date('dob')->default('0000-00-00');
                $table->string('status');
                $table->string('position');
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
        Schema::drop('staff');
    }

    /**
     * Staff Table Seeder
     */
    private function seeder()
    {
        DB::table('staff')->insert(
            array(
                array(
                    'kh_name' => 'យួម ធារ៉ា',
                    'en_name' => 'Yuom Theara',
                    'sex' => 'M', // M=Male, F=Female
                    'dob' => '1982-01-01',
                    'status' => 'Married', // Single, Married, Divorced
                    'position' => 'Cashier',
                    'address' => 'Wattamim Village, Odambang 1 Commune, Sangke District, Battambang Province',
                    'telephone' => '070 550 880',
                    'email' => 'yuom.theara@gmail.com',
                    'created_at' => new DateTime(),
                    'updated_at' => new DateTime(),
                )
            )
        );
    }

}
