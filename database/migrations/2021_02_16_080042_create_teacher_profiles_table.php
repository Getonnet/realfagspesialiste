<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeacherProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teacher_profiles', function (Blueprint $table) {
            $table->id();
            $table->date('dob');
            $table->string('contact', 20);
            $table->string('address');
            $table->string('zip', 32);
            $table->string('city', 100);
            $table->enum('gender',['Male', 'Female', 'Other'])->nullable();
            $table->float('grade')->comment('Dropdown 2.0 - 6.0 with a interval of .50');
            $table->float('working_hour')->comment('Working Hour in a week');
            $table->string('description')->nullable();
            $table->string('cv')->nullable();
            $table->string('diploma')->nullable()->comment('Diplomas certificate');
            $table->foreignId('education_area_id')->comment('Educational Institute')->constrained()->onDelete('cascade')->onUpdate('No Action');;
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
        Schema::dropIfExists('teacher_profiles');
    }
}
