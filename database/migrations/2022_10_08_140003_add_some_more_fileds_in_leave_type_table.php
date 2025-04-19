<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSomeMoreFiledsInLeaveTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('leave_types', function (Blueprint $table) {
            $table->string("borrowed_entitlement_time_off_limit")->nullable();
            $table->string("set_bulk_leave_month")->nullable();
            $table->string("set_bulk_leave_days")->nullable();
            $table->string("delay_time_off")->nullable();
            $table->string("delay_time_off_month")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('leave_types', function (Blueprint $table) {
            $table->dropColumn("borrowed_entitlement_time_off_limit");
            $table->dropColumn("set_bulk_leave_month");
            $table->dropColumn("set_bulk_leave_days");
            $table->dropColumn("delay_time_off");
            $table->dropColumn("delay_time_off_month");
        });
    }
}
