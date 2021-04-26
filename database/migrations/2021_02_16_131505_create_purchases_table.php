<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable()->comment('Package name');
            $table->float('hours')->default(0);
            $table->double('price')->default(0);
            $table->double('discount')->default(0)->comment('Based on coupon or other else');
            $table->string('coupon')->nullable()->comment('Based on package if coupon applicable');
            $table->string('note')->nullable();
            $table->enum('status',['Pending', 'Paid', 'Unpaid','Active'])->default('Active');
            $table->foreignId('package_id')->nullable()->constrained()->onDelete('Set Null')->onUpdate('No Action');
            $table->foreignId('user_id')->comment('Student ID')->constrained()->onDelete('cascade')->onUpdate('No Action');
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
        Schema::dropIfExists('purchases');
    }
}
