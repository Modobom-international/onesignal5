<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LinkSystemGlobalRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }
    
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'status'=> 'required',
            'type' =>'required',
            'link_web_1' =>'required',
            'link_web_2' =>'required',
            'share' =>'required',
        ];
    }
    
    public function messages()
    {
        return [
        
        ];
    }
}
