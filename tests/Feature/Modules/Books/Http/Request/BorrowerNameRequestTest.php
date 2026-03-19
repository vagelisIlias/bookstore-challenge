<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\Books\Http\Request;
use App\Modules\Books\Http\Request\BorrowerNameRequest;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

final class BorrowerNameRequestTest extends TestCase
{
    public function test_borrower_name_request_requires_name(): void
    {
        // Arrange
        $request = new BorrowerNameRequest([
            'borrower_name' => ''
        ]);

        // Act
        $validator = Validator::make($request->all(), $request->rules());

        // Assert
        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('borrower_name', $validator->errors()->messages());
    }
}
