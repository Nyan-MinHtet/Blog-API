<?php
namespace App\Http\Helpers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class PostValidateRequest extends FormRequest{
    public function authorize(): bool {
        return Auth::check();
    }
    public function rules(): array {
         $rules = [
            'title'     => 'required|string|max:255', 
            'content'   => 'required|string',
            'status'    => 'sometimes|in:Public,Private',
            'series_id' => 'nullable|integer|exists:series,id', 
            'category_id' => 'nullable|integer|exists:categories,id', 
        ];
        return $rules;
    }
}