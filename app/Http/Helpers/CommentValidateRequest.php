<?php
namespace App\Http\Helpers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class CommentValidateRequest extends FormRequest{
    public function authorize() : bool
    {
        return Auth::check();
    }
    public function rules() : array 
    {
        $rules = [
            'body' => 'required',
            'post_id' => 'exists:posts,id'
        ];
        return $rules;
    }
}