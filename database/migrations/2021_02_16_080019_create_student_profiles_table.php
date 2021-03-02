<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_profiles', function (Blueprint $table) {
            $table->id();
            $table->date('dob')->nullable();
            $table->string('contact', 20);
            $table->string('address');
            $table->string('zip', 32);
            $table->string('city', 100);
            $table->string('institute')->nullable()->comment('Educational Institute');
            $table->enum('gender',['Male', 'Female', 'Other'])->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade')->onUpdate('No Action');
            $table->softDeletes();
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
        Schema::dropIfExists('student_profiles');
    }
}
