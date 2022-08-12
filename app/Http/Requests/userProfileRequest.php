<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class userProfileRequest extends FormRequest
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
                'firstname' => 'required|string|min:3|max:30',
                'lastname' => 'required|string|min:30|max:30',
                 'gender' => 'required|string',
        ];

      
    }
}
