<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NotificationRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'name' => 'required|string',
        ];

        if ($this->getMethod() == 'POST') {
            $rules['name'] = "";
        } else {
            $rules['name'] = "";
        }

        return $rules;
    }
}
