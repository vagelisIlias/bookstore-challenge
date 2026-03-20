<?php

declare(strict_types=1);

namespace App\Modules\Authors\Database;

use App\Modules\Authors\Exceptions\AuthorNotFoundException;
use App\Modules\Books\Database\Book;
use App\Modules\Library\Database\Model;
use Database\Factories\AuthorFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Author extends Model
{
    use HasUuids, HasFactory;

    protected $fillable = ['name'];

    protected $visible = ['uuid', 'name'];

    public static function newModelNotFoundException(): AuthorNotFoundException
    {
        return new AuthorNotFoundException();
    }

    public function uniqueIds(): array
    {
        return ['uuid'];
    }

    public function books(): HasMany
    {
        return $this->hasMany(Book::class);
    }

    public static function new(string $name): self
    {
        return new self(['name' => $name]);
    }

    protected static function newFactory(): AuthorFactory
    {
        return new AuthorFactory();
    }
}
