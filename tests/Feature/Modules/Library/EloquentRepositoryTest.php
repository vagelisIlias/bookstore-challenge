<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\Library;

use App\Modules\Library\Database\EloquentRepository;
use App\Modules\Library\Database\Model;
use App\Modules\Library\Database\QueryFilter;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Tests\TestCase;

class EloquentRepositoryTest extends TestCase
{
    public function test_findAll_applies_filter_and_paginate(): void
    {
        // Arrange
        $mockModel = $this->createMock(Model::class);
        $mockQuery = $this->createMock(Builder::class);

        $mockModel->method('newQuery')->willReturn($mockQuery);

        $filter = $this->createMock(QueryFilter::class);
        $filter->method('apply')->with($mockQuery)->willReturn($mockQuery);

        $mockQuery->method('paginate')->willReturn($this->createMock(LengthAwarePaginator::class));

        $repo = new EloquentRepository($mockModel);

        // Act
        $result = $repo->findAll($filter);

        // Assert
        $this->assertInstanceOf(LengthAwarePaginator::class, $result);
    }

    public function test_requireByUuid_returns_model_if_found(): void
    {
        // Arrange
        $mockModel = $this->createMock(Model::class);
        $mockQuery = $this->createMock(Builder::class);

        $mockQuery->method('where')->willReturnSelf();
        $mockQuery->method('firstOrFail')->willReturn($mockModel);
        $mockModel->method('newQuery')->willReturn($mockQuery);

        $repo = new EloquentRepository($mockModel);

        // Assert
        $this->assertSame($mockModel, $repo->requireByUuid('test-uuid'));
    }
}
