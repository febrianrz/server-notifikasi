<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TemplateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'channel_id' => 'required|exists:channels,id',
            'name'       => 'required|string',
            'description'=> 'required|string',
            'template'   => 'required|string'
        ];

        if ($this->getMethod() == 'POST') {
            $rules['code'] = 'required|unique:templates,code';
        } else {
            $rules['code'] = "required";
        }

        return $rules;
    }
}
