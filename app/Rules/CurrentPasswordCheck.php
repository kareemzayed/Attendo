<?php

declare(strict_types=1);

namespace App\Rules;

use Closure;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Validation\ValidationRule;

class CurrentPasswordCheck implements ValidationRule
{
    /**
     * Constructor with readonly user property
     *
     * @param User $user
     */
    public function __construct(
        protected readonly User $user
    ) {}

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!Hash::check($value, $this->user->password)) {
            $fail(__('messages.current_password_is_incorrect'));
        }
    }
}
