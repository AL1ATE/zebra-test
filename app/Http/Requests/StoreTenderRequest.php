<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTenderRequest extends FormRequest
{
    public function authorize(): true
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'external_code' => 'required|numeric|unique:tenders,external_code',
            'number' => 'required|string',
            'status' => 'required|string',
            'name' => 'required|string',
            'updated_at_original' => 'required|date',
        ];
    }
}

