<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSomeMoreColumnInLeaveTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('leave_types', function (Blueprint $table) {
            $table->string('measure')->nullable();
            $table->boolean('employees_qualify')->nullable();
            $table->string('requesting_time')->nullable();
            $table->string('value_round')->nullable();
            $table->string('date_join')->nullable();
            $table->string('specific_date')->nullable();
            $table->boolean('delay_time')->nullable();
            $table->string('month_delay')->nullable();
            $table->boolean('tenure')->nullable();
            $table->string('carried_over')->nullable();
            $table->boolean('carry')->nullable();
            $table->boolean('policy')->nullable();
            $table->boolean('notice_when_booking')->nullable();
            $table->string('approves')->nullable();
            $table->string('notified')->nullable();
            $table->boolean('carry_over_expire')->nullable();
            $table->string('When_carry_over_expire')->nullable();
            $table->string('how_carry_over')->nullable();
            $table->string('color')->nullable();
            $table->string('policy_wording')->nullable();
            $table->string('annual_allowance_exceeded')->nullable();
            $table->string('more_than_accrued')->nullable();
            $table->string('notice_given')->nullable();
            $table->string('probation_period')->nullable();
            $table->string('blackout_day')->nullable();
            $table->string('entitlement_time_off')->nullable();
            $table->string('when_entitlement_time_off')->nullable();
            $table->string('how_entitlement_time_off')->nullable();
            $table->boolean('can_take_entitlement_time_off')->nullable();
            $table->string('borrowed_entitlement_time_off')->nullable();
            $table->string('show_dashboard_balance')->nullable();
            $table->boolean('apply_upper_limit_entitlement_time_off')->nullable();
            $table->boolean('prevent_accrual_period')->nullable();
            $table->string('prevent_accrual_period_field')->nullable();
            $table->boolean('set_leave_amount_immediately')->nullable();
            $table->string('set_leave_amount_immediately_specify')->nullable();
            $table->boolean('set_bulk_leave_amount')->nullable();
            $table->boolean('leave_valid')->nullable();
        
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
            $table->dropColumn('measure');
            $table->dropColumn('employees_qualify');
            $table->dropColumn('requesting_time');
            $table->dropColumn('value_round');
            $table->dropColumn('date_join');
            $table->dropColumn('specific_date');
            $table->dropColumn('delay_time');
            $table->dropColumn('month_delay');
            $table->dropColumn('tenure');
            $table->dropColumn('carried_over');
            $table->dropColumn('carry');
            $table->dropColumn('policy');
            $table->dropColumn('notice_when_booking');
            $table->dropColumn('approves');
            $table->dropColumn('notified');
            $table->dropColumn('carry_over_expire');
            $table->dropColumn('When_carry_over_expire');
            $table->dropColumn('how_carry_over');
            $table->dropColumn('color');
            $table->dropColumn('policy_wording');
            $table->dropColumn('annual_allowance_exceeded');
            $table->dropColumn('more_than_accrued');
            $table->dropColumn('notice_given');
            $table->dropColumn('probation_period');
            $table->dropColumn('blackout_day');
            $table->dropColumn('entitlement_time_off');
            $table->dropColumn('when_entitlement_time_off');
            $table->dropColumn('how_entitlement_time_off');
            $table->dropColumn('can_take_entitlement_time_off');
            $table->dropColumn('borrowed_entitlement_time_off');
            $table->dropColumn('show_dashboard_balance');
            $table->dropColumn('apply_upper_limit_entitlement_time_off');
            $table->dropColumn('prevent_accrual_period');
            $table->dropColumn('prevent_accrual_period_field');
            $table->dropColumn('set_leave_amount_immediately');
            $table->dropColumn('set_leave_amount_immediately_specify');
            $table->dropColumn('set_bulk_leave_amount');
            $table->dropColumn('leave_valid');
        });
    }
}
