<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkingDaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('working_days', function (Blueprint $table) {
            $table->id();
            $table->boolean('monday')->default(1);
            $table->boolean('tuesday')->default(1);
            $table->boolean('wednesday')->default(1);
            $table->boolean('thursday')->default(1);
            $table->boolean('friday')->default(1);
            $table->boolean('saturday')->default(1);
            $table->boolean('sunday')->default(1);
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
        Schema::dropIfExists('working_days');
    }
}
