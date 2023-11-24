<?php

namespace App\Http\Requests\Accounting;

use Illuminate\Foundation\Http\FormRequest;

class PettyCashRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'petty_cash_number' => ['required', 'string'],
            'received_by' => ['nullable', 'string'],
            'received_by_employee_id' => ['nullable', 'string'],
            'date' => ['required', 'date_format:Y-m-d'],
            'information' => ['required', 'string'],
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
