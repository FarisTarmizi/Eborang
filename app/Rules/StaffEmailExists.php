<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\DB;

class StaffEmailExists implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString $fail
     */
    public $staffId;

    public function __construct($staffId)
    {
        $this->staffId = $staffId;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $exists = DB::table('user_info')->where('id', $this->staffId)->where('email',
            $value)->exists();
        if (!$exists) {
            $fail('E-mel yang diberikan tidak sepadan dengan ID.');
        }
    }
}
