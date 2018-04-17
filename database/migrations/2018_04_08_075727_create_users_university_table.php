<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersUniversityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_university', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_user'); 
            $table->string('full_name');
            $table->string('short_name');
            $table->string('other_names'); 
            $table->integer('secondary_inst'); 
            $table->integer('parent_institution');  
            $table->integer('form_attitude');
            $table->integer('year_of_foundation'); 

            $table->integer('has_hostel');
            $table->integer('has_military_department');  

            $table->string('license_nr');
            $table->date('license_nr_from');

            $table->string('accreditation_nr');
            $table->date('accreditation_nr_from');  
            $table->text('description');  


            $table->integer('program_type');
            $table->integer('id_category'); 
             
             
             
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
