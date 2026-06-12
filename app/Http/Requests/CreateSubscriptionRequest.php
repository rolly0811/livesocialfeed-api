<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateSubscriptionRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'event_code' => ['unique:subscriptions','required'],
            'hash_tag' => ['required'],
            'start_date' => ['required'],
            'end_date' => ['required'],
            'theme' => ['required'],
            'background' => ['required'],
            'logo' => ['required'],
            'enable_message_approval' => ['required'],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'errors' => $validator->errors()->all(),
            'status' => 'failed'
        ], 400));
    }
}
