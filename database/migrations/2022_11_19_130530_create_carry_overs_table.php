<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarryOversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carry_overs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('employee_id');
            $table->bigInteger('leave_type_id');
            $table->date('expiry_date')->nullable();
            $table->bigInteger('total')->nullable();
            $table->bigInteger('grant_limit')->nullable();
            $table->bigInteger('taken')->nullable();
            $table->bigInteger('remaining')->nullable();
            $table->bigInteger('expire_flag')->nullable();
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
        Schema::dropIfExists('carry_overs');
    }
}
