<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTenureInLeavesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tenure_in_leaves', function (Blueprint $table) {
            $table->id();
            $table->integer('leave_type_id');
            $table->integer('year_service');
            $table->integer('additional_days');
            $table->integer('total_days');
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
        Schema::dropIfExists('tenure_in_leaves');
    }
}
