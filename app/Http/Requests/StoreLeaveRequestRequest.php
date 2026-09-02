<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLeaveRequestRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'type' => ['required','string'],
            'starts_on' => ['required','date'],
            'ends_on' => ['required','date','after_or_equal:starts_on'],
            'days' => ['required', 'integer', 'min:1'],
        ];
    }
}
