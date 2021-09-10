<?php

namespace App\Rules;

use App\User;

use Illuminate\Contracts\Validation\Rule;

class DuplicateRole implements Rule
{
    
    public $role;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($role = ['CLIENT'])
    {
        $this->role = $role;
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
        $user = User::where('phone', '=', $value)->whereIn('role',$this->role)->first();
        return $user === null;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('validation.unique');
    }
}
