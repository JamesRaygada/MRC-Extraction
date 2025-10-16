<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadContractRequest extends FormRequest {
    public function authorize(): bool { return true; }

    public function rules(): array {
        return [
            'title' => ['required','string','max:255'],
            'uploader_email' => ['nullable','email'],
            'primary' => ['required','file','mimes:pdf,doc,docx','max:102400'],
            'spreadsheets.*' => ['file','mimes:xlsx,csv','max:51200'],
        ];
    }
}
