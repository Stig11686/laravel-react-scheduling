<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\Rule;
use Carbon\Carbon;

class ValidateEndDate implements Rule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function passes($attribute, $value)
    {
         // Retrieve the start date from the request
         $startDate = request()->input('start_date');

         // Parse the start and end dates using Carbon
         $start = Carbon::parse($startDate);
         $end = Carbon::parse($value);

         // Check if end date is at least 367 days after the start date
         $isAfter367Days = $end->diffInDays($start) >= 367;

          // Check if end date is within 24 months (730 days) after the start date
         $isWithin24Months = $end->diffInDays($start) <= 730;

         // Set custom error messages for each condition
        if (!$isAfter367Days) {
            $this->message = 'The end date must be at least 367 days after the start date.';
        } elseif (!$isWithin24Months) {
            $this->message = 'The end date must be within 24 months of the start date.';
        }

        // Return true if both conditions are met
        return $isAfter367Days && $isWithin24Months;

         // Return true if both conditions are met
         return $isAfter367Days && $isWithin24Months;
    }

    public function message(){
        return $this->message;
    }
}
