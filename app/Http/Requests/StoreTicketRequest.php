<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTicketRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'subject' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'category_id' => ['required', 'exists:categories,id'],
            'priority_id' => ['required', 'exists:priorities,id'],
            'attachments' => ['nullable', 'array'],
            'attachments.*' => ['file', 'max:5120', 'mimes:pdf,jpg,jpeg,png,docx'],
    ];

        if ($this->user()->hasAnyRole(['admin', 'agent'])) {
            $rules['customer_id'] = ['required', 'exists:users,id'];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'subject.required' => 'Subjek tiket wajib diisi.',
            'description.required' => 'Deskripsi tiket wajib diisi.',
            'category_id.required' => 'Kategori wajib dipilih.',
            'priority_id.required' => 'Prioritas wajib dipilih.',
            'customer_id.required' => 'Customer wajib dipilih.',
            'attachments.*.max' => 'Ukuran file maksimal 5MB.',
            'attachments.*.mimes' => 'Format file harus pdf, jpg, jpeg, png, atau docx.',
        ];
    }
}