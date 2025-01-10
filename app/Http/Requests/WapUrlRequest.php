<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WapUrlRequest extends FormRequest
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
            'id_user'=> 'required',
        ];
    }
    
    public function messages()
    {
    
        return [
            'id_user.required' => 'user is required',
        ];
    }
}
