<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Domains\Production\ProductionScheduleDetailPackValue;

class ProductionScheduleRemainingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('manage production');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'production_schedule_id' => ['required', 'numeric'],
            'dimension_p' => ['required'],
            'pieces' => ['required', 'numeric'],
            'pack' => ['required', 'string', 'in:' . ProductionScheduleDetailPackValue::PACK_AVAL],
            'production_total' => ['required', 'numeric'],
            'description' => ['string', 'nullable'],
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
