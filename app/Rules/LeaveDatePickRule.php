<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Utility;

class LeaveDatePickRule implements Rule
{
    public $request;
    public $error;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($request)
    {
        $this->request = $request;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if ($this->request['leave_bases'] == 'single_days') {
            if ($this->request['single_date'] < now()) {
                $this->error = 'Please select valid date.';
                return false;
            }
            return true;
        } else if ($this->request['leave_bases'] == 'multiple_days') {
            if ($this->request['start_date'] < now() OR $this->request['end_date'] < now() OR $this->request['end_date'] < $this->request['start_date']) {
                $this->error = 'Please select valid start date and end date.';
                return false;
            }
            return true;
        } else if ($this->request['leave_bases'] == 'hour_based') {
            if ($attribute == 'single_date' && $this->request['single_date'] < now()) {
                $this->error = 'Please select valid date.';
                return false;
            } else if ($attribute == 'start_time' OR $attribute == 'end_time') {
                if ($this->request['start_time'] > $this->request['end_time']) {
                    $this->error = 'Please select valid start time and end time.( t2)';
                    return false;
                }
            }
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->error;
    }
}
