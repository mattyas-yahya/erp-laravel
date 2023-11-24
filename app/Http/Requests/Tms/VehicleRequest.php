<?php

namespace App\Http\Requests\Tms;

use Illuminate\Foundation\Http\FormRequest;

class VehicleRequest extends FormRequest
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
            'type' => ['required', 'string'],
            'name' => ['required', 'string'],
            'model' => ['required', 'string'],
            'manufacture_year' => ['required', 'date_format:Y'],
            'color' => ['required', 'string'],
            'image' => ['nullable', 'mimes:jpg,png,jpeg,gif,svg', 'max:2048',],
            'stnk' => ['nullable', 'mimes:jpg,png,jpeg,gif,svg', 'max:2048',],
            'bpkb' => ['nullable', 'mimes:jpg,png,jpeg,gif,svg', 'max:2048',],
            'group' => ['required', 'string'],
            'registration_number' => ['required', 'string'],
            'engine_number' => ['required', 'string'],
            'chassis_number' => ['required', 'string'],
            'fuel_type' => ['required', 'string'],
            'fuel_measurement_unit' => ['required', 'string'],
            'track_usage_as' => ['required', 'string'],
            'auxilary_meter' => ['required', 'string', 'in:yes,no'],
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
