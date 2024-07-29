<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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

            $rules =
            [
                'name' => 'required',
                'email' => 'required|email|unique:mysql.users,email,'.$this->id,
                'confirm_password' =>'same:password',
                'image' => 'mimes:jpeg,png,jpg',
            ];



        return $rules;
    }
}
