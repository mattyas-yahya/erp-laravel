<?php

namespace App\Http\Requests\Tms;

use Illuminate\Foundation\Http\FormRequest;

class AssignmentRequest extends FormRequest
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
            'vehicle_id' => ['required', 'numeric'],
            'delivery_order_number' => ['required', 'string'],
            'driver_id' => ['required', 'numeric'],
            'started_at' => ['required', 'date_format:Y-m-d'],
            'starting_odometer' => ['sometimes', 'numeric'],
            'last_odometer' => ['nullable', 'numeric'],
            'comment' => ['nullable', 'string'],
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
