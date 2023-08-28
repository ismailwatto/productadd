<?php

namespace App\Http\Requests;

use App\Rules\AvailableQuantity;
use Illuminate\Foundation\Http\FormRequest;

class OrderStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $rules = [
            'product_name.*' => 'required|string|max:255',
            'quantity.*' => ['required', 'integer', 'min:1',  new AvailableQuantity($this->input('product_name', [])),],
            'total_price.*' => 'required|numeric|min:0.01',
            'discountSelect' => 'required|string|in:fixed,percentage',
            'discountedAmount' => 'required_if:discountSelect,fixed|numeric|min:0',
        ];

        if ($this->input('newUser') == 'on') {
            $rules['email'] = 'required|email|max:255|unique:users';
            $rules['name'] = 'required|string|max:255';
            $rules['phone'] = 'required|string|max:20';
            $rules['address'] = 'required|string|max:1000';
        } else {
            $rules['user'] = 'required|exists:users,id';
        }

        return $rules;
    }
}
