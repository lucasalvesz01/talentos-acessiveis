<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadCurriculumRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'curriculum' => 'required|file|mimes:pdf|max:2048',
        ];
    }
    public function messages(): array
    {
        return [
            'curriculum.required' => 'Por favor, selecione um arquivo PDF para enviar.',
            'curriculum.mimes' => 'O arquivo deve ser um PDF.',
            'curriculum.max' => 'O arquivo não pode ser maior que 2MB.',
        ];
    }

}
