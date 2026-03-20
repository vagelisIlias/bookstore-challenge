<?php

declare(strict_types=1);

namespace App\Modules\Books\Database;

use App\Modules\Authors\Database\Author;
use App\Modules\Books\Exceptions\BookIsBorrowedException;
use App\Modules\Books\Exceptions\BookIsNotBorrowedException;
use App\Modules\Books\Exceptions\BookNotFoundException;
use App\Modules\Library\Database\Model;
use Database\Factories\BookFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Book extends Model
{
    use HasFactory;
    use HasUuids;

    protected $fillable = [
        'uuid',
        'title',
        'isbn',
        'author_id',
        'available',
        'borrower_name'
    ];

    protected $visible = [
        'uuid',
        'title',
        'isbn',
        'author',
        'available',
        'borrower_name'
    ];

    protected $with = [
        'author'
    ];

    protected $casts = [
        'available' => 'bool'
    ];

    public function uniqueIds(): array
    {
        return ['uuid'];
    }

    public static function newModelNotFoundException(): BookNotFoundException
    {
        return new BookNotFoundException();
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class);
    }

    public static function new(string $title, string $isbn, int $authorId): self
    {
        return new self(['title' => $title, 'isbn' => $isbn, 'author_id' => $authorId]);
    }

    public function borrow(string $borrowerName): void
    {
        if (!$this->available) {
            throw new BookIsBorrowedException();
        }

        $this->available = false;
        $this->borrower_name = $borrowerName;
    }

    public function return(): void
    {
        if ($this->available) {
            throw new BookIsNotBorrowedException();
        }

        $this->available = true;
        $this->borrower_name = null;
    }

    protected static function newFactory(): BookFactory
    {
        return new BookFactory();
    }
}
