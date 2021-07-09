<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class RSAnumber implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        $start = ['073', '081', '061', '078', '071', '082', '076', '083', '068', '060', '067', '072', '067', '063'];
		
		for($i = 0; $i < count($start); $i++) {
			if(preg_match('/^0[0-9]{9}$/', $value) && substr($value, 0, 3) === $start[$i]) {
				return true;
			}
		}
		return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Please add a valid South African number.';
    }
}
