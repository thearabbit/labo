<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCategoryTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'category',
            function (Blueprint $table) {
                $table->increments('id');
                $table->string('kh_name');
                $table->string('en_name');
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
        Schema::drop('category');
    }

    /**
     * Category Table Seeder
     */
    private function seeder()
    {
        DB::table('category')->insert(
            array(
                array(
                    'kh_name' => 'Hematologie',
                    'en_name' => 'Hematologie',
                    'des' => '',
                    'created_at' => new DateTime(),
                    'updated_at' => new DateTime(),
                ),
                array(
                    'kh_name' => 'Urologie',
                    'en_name' => 'Urologie',
                    'des' => '',
                    'created_at' => new DateTime(),
                    'updated_at' => new DateTime(),
                ),
            )
        );
    }

}
