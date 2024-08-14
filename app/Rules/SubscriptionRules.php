<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class SubscriptionRules implements ValidationRule
{
    private string $urlPrefix;

    public function __construct(){
        $this->urlPrefix = 'https://www.olx.ua';
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!str_starts_with($value, $this->urlPrefix)) {
            $fail('The :attribute must start with ' . $this->urlPrefix);
        }
    }
}
