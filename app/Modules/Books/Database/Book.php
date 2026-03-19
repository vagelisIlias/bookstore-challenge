<?php

declare(strict_types=1);

namespace App\Modules\Books\Database;

use App\Modules\Authors\Database\Author;
use Database\Factories\BookFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Book extends Model
{
    use HasUuids, HasFactory;

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

    /**
     * Let Laravel know where the factory is, now that it’s inside modules
     */
    protected static function newFactory(): BookFactory
    {
        return new BookFactory();
    }
}
