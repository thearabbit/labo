<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAgentTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'agent',
            function (Blueprint $table) {
                $table->increments('id');
                $table->string('kh_name');
                $table->string('en_name');
                $table->string('sex');
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
        Schema::drop('agent');
    }

    /**
     * Agent Table Seeder
     */
    private function seeder()
    {
        DB::table('agent')->insert(
            array(
                array(
                    'kh_name' => 'វណ្ណី',
                    'en_name' => 'Vanny',
                    'sex' => 'M',
                    'address' => 'Battambang',
                    'telephone' => '',
                    'email' => '',
                    'created_at' => new DateTime(),
                    'updated_at' => new DateTime(),
                ),
                array(
                    'kh_name' => 'អានដា',
                    'en_name' => 'Anda',
                    'sex' => 'F',
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
