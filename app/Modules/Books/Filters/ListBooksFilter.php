<?php

declare(strict_types=1);

namespace App\Modules\Books\Filters;

use App\Modules\Library\Database\QueryFilter;
use Illuminate\Database\Eloquent\Builder;

readonly class ListBooksFilter implements QueryFilter
{
    public function __construct(
        private ?bool $available = null,
        private ?string $search = null,
        private ?string $authorUuid = null
    ) {
    }

    public function apply(Builder $query): Builder
    {
        if (!is_null($this->available)) {
            $query->where('available', $this->available);
        }

        if (!is_null($this->search)) {
            $query->where('title', 'like', '%' . $this->search . '%');
        }

        if (!is_null($this->authorUuid)) {
            $query->whereHas('author', fn ($q) => $q->where('uuid', $this->authorUuid));
        }

        return $query;
    }
}
