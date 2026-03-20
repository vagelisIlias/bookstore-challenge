<?php

declare(strict_types=1);

namespace App\Modules\Books\Http\Request;

use Illuminate\Foundation\Http\FormRequest;

final class StoreBookRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'isbn' => 'required|string|max:20',
            'author_uuid' => 'required|string|exists:authors,uuid',
        ];
    }
}
