<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WebNotificationRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'to'    => 'required',
            'title' => 'required|string|max:190',
            'content'=> 'required',
            'type'  => 'required',
            'link'  => 'nullable|url',
        ];

        return $rules;
    }
}
