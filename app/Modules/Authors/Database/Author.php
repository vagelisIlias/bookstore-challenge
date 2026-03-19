<?php

declare(strict_types=1);

namespace App\Modules\Authors\Database;

use App\Modules\Books\Database\Book;
use Database\Factories\AuthorFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Author extends Model
{
    use HasUuids, HasFactory;

    protected $fillable = ['name'];

    public function uniqueIds(): array
    {
        return ['uuid'];
    }

    public function books(): HasMany
    {
        return $this->hasMany(Book::class);
    }

    /**
     * Let Laravel know where the factory is, now that it’s inside modules
     */
    protected static function newFactory(): AuthorFactory
    {
        return new AuthorFactory();
    }
}
