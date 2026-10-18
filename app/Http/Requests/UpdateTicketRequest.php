<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTicketRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'subject' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'category_id' => ['required', 'exists:categories,id'],
            'priority_id' => ['required', 'exists:priorities,id'],
            'attachments' => ['nullable', 'array'],
            'attachments.*' => ['file', 'max:5120', 'mimes:pdf,jpg,jpeg,png,docx'],
        ];
    }

    public function messages(): array
    {
        return [
            'subject.required' => 'Subjek tiket wajib diisi.',
            'description.required' => 'Deskripsi tiket wajib diisi.',
            'category_id.required' => 'Kategori wajib dipilih.',
            'priority_id.required' => 'Prioritas wajib dipilih.',
            'attachments.*.max' => 'Ukuran file maksimal 5MB.',
            'attachments.*.mimes' => 'Format file harus pdf, jpg, jpeg, png, atau docx.',
        ];
    }
}