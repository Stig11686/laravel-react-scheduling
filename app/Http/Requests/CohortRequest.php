<?php

namespace App\Http\Requests;

use App\Rules\ValidateEndDate;
use Illuminate\Foundation\Http\FormRequest;

class CohortRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'course_id' => 'required',
            'start_date' => 'required|date',
            'end_date' => ['required', 'date', new ValidateEndDate()],
            'places' => 'required|integer'
        ];
    }
}
