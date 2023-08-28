<?php

namespace App\Rules;

use Closure;
use App\Models\Item;
use Illuminate\Contracts\Validation\ValidationRule;

class AvailableQuantity implements ValidationRule
{
    protected $productNames;

    public function __construct($productNames)
    {
        $this->productNames = $productNames;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $parts = explode('.', $attribute);
        $index = $parts[1];
        if(count($this->productNames) > 0){
            $item = Item::find($this->productNames[$index]);
            if (!$item) {
                $fail('The item doesnot exist');
            }
            else if ($value > $item->quantity) {
                $fail('The quantity requested exceeds the available quantity for this item');
            }
        }
    }
}
