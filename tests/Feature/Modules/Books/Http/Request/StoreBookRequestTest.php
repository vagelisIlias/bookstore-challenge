<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\Books\Http\Request;
use App\Modules\Books\Http\Request\StoreBookRequest;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

final class StoreBookRequestTest extends TestCase
{
    public function test_store_book_request_requires_title_isbn_author_uuid(): void
    {
        // Arrange
        $request = new StoreBookRequest([
            'title' => '',
            'isbn' => '',
            'author_uuid' => ''
        ]);

        // Act
        $validator = Validator::make($request->all(), $request->rules());

        // Assert
        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('author_uuid', $validator->errors()->messages());
    }
}
