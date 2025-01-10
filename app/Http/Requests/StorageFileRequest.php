<?php

namespace App\Http\Requests;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorageFileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
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
            'version'=> 'required',
            'url' =>'required',
            'changelog' =>'required',
            'mandatory' =>'required',
            'app_id' =>'required|unique:storage_files,app_id,' .$this->id,
        ];
    }
    
    public function messages()
    {
        return [
        
        ];
    }
}
