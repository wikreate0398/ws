<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersWorkExperienceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_work_experience', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_user');
            $table->integer('from_year');
            $table->integer('to_year');
            $table->string('institution_name');
            $table->string('position');
            $table->text('description'); 
            $table->integer('direction'); 
            $table->string('responsibility');  
            $table->timestamp('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
