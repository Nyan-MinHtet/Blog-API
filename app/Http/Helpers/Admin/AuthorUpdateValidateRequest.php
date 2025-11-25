<?php
namespace App\Http\Helpers\Admin;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class AuthorUpdateValidateRequest extends FormRequest{
    public function authorize() : bool
    {
        return Auth::check();
    }
    public function rules() : array 
    {
        $rules = [
            'status' => 'required | in:Active,Suspended',
        ];
        return $rules;
    }
}