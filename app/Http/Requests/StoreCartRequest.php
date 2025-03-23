<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth; // Tambahkan ini

class StoreCartRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check(); // Pastikan user terautentikasi
    }

    public function rules(): array
    {
        return [
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ];
    }
}
