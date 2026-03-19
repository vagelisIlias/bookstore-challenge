<?php

declare(strict_types=1);

namespace App\Modules\Books\Database;

use App\Modules\Authors\Database\Author;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Book extends Model
{
    use HasUuids;

    protected $fillable = [
        'uuid',
        'title',
        'isbn',
        'author_id',
        'is_active',
        'available',
        'borrower_name'
    ];

    public function isAvailable(): bool
    {
        return (bool) $this->available;
    }

    public function uniqueIds(): array
    {
        return ['uuid'];
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class);
    }
}
