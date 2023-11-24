<?php

namespace App\Http\Requests\Accounting;

use Illuminate\Foundation\Http\FormRequest;

class CashInHandRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    // TODO: CashInHandDetail rule here
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'cash_in_hand_number' => ['required', 'string'],
            'date' => ['required', 'date_format:Y-m-d'],
            'initial_balance' => ['required', 'numeric'],
            'kasbon_balance' => ['required', 'numeric'],
            'account_balance' => ['required', 'numeric'],
            'information' => ['nullable', 'string'],
        ];
    }

        /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $messages = $validator->getMessageBag();

            return redirect()->back()->with('error', $messages->first());
        });
    }
}
