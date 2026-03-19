<?php

declare(strict_types=1);

namespace App\Modules\Books\Http\Request;

use Illuminate\Foundation\Http\FormRequest;

final class BorrowerNameRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'borrower_name' => 'required|string|max:255',
        ];
    }
}
