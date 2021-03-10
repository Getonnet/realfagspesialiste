<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimeLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('time_logs', function (Blueprint $table) {
            $table->id();
            $table->timestamp('event_start');
            $table->timestamp('start_time')->useCurrent();
            $table->timestamp('end_time')->nullable();
            $table->float('hour_spend')->default(0)->comment('Based on start and end time');
            $table->string('subject_name')->nullable();
            $table->string('student_name')->nullable();
            $table->string('student_email')->nullable();
            $table->string('teacher_name')->nullable();
            $table->string('teacher_email')->nullable();
            $table->text('description')->nullable()->comment('Description of lesson');
            $table->text('summery')->nullable()->comment('Summary of the session');
            $table->tinyInteger('motivational')->nullable()->comment('Motivational Ranking of the student [scale of 1-10]');
            $table->tinyInteger('understanding')->nullable()->comment('Understanding Ranking of the student [scale of 1-10]');
            $table->foreignId('subject_id')->nullable()->constrained()->onDelete('Set Null')->onUpdate('No Action');
            $table->foreignId('student_id')->nullable()->constrained('users')->onDelete('Set Null')->onUpdate('No Action');
            $table->foreignId('teacher_id')->nullable()->constrained('users')->onDelete('Set Null')->onUpdate('No Action');
            $table->enum('status',['Pending', 'Running', 'End'])->default('Pending');
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
        Schema::dropIfExists('time_logs');
    }
}
