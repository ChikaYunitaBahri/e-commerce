<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth; // Tambahkan ini

class UpdateCartRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check(); // Pastikan user terautentikasi
    }

    public function rules(): array
    {
        return [
            'quantity' => 'required|integer|min:1',
        ];
    }
}
