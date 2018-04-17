<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewFieldsUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) { 
            $table->integer('user_type'); 
            $table->string('name');
            $table->string('surname');
            $table->string('patronymic'); 
            $table->integer('city');
            $table->dateTime('date_birth');
            $table->string('phone');
            $table->string('site');             
            $table->string('email')->unique();
            $table->string('password'); 
            $table->rememberToken();
            $table->timestamps();
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


