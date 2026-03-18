<?php

declare(strict_types=1);

namespace App\Modules\Authors\Database;

use App\Modules\Books\Database\Book;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Author extends Model
{
    use HasUuids;

    protected $fillable = ['name'];

    public function uniqueIds(): array
    {
        return ['uuid'];
    }

    public function books(): HasMany
    {
        return $this->hasMany(Book::class);
    }
}
