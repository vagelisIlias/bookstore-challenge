<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\Authors\Http\Request;

use App\Modules\Authors\Http\Request\StoreAuthorRequest;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

final class StoreAuthorRequestTest extends TestCase
{
    public function test_store_author_request_requires_name(): void
    {
        // Arrange
        $request = new StoreAuthorRequest([
            'name' => ''
        ]);

        // Act
        $validator = Validator::make($request->all(), $request->rules());

        // Assert
        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('name', $validator->errors()->messages());
    }
}
