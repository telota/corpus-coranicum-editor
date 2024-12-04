<?php

namespace App\Rules;

use App\Models\Koran;
use App\Models\Koranstelle;
use Closure;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Log;

class QuranVerseExists implements DataAwareRule, ValidationRule
{
    /**
     * All of the data under validation.
     *
     * @var array<string, mixed>
     */
    protected $data = [];

    /**
     * Set the data under validation.
     *
     * @param array<string, mixed> $data
     */
    public function setData(array $data): static
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Run the validation rule.
     *
     * @param \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $verse = Koranstelle::where('sure', $this->data['sure'])
            ->where('vers', $this->data['vers'])
            ->first();

        if(!isset($verse)){
            $fail('The quran verse (sura, verse) does not exists.');
        }

    }
}
