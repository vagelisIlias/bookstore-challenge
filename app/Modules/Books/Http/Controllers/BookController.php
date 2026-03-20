<?php

declare(strict_types=1);

namespace App\Modules\Books\Http\Controllers;

use App\Modules\Books\Commands\BorrowBook;
use App\Modules\Books\Commands\CreateBook;
use App\Modules\Books\Commands\ReturnBook;
use App\Modules\Books\Database\BookRepository;
use App\Modules\Books\Filters\ListBooksFilter;
use App\Modules\Books\Http\Request\BorrowerNameRequest;
use App\Modules\Books\Http\Request\StoreBookRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

final class BookController
{
    public function __construct(private BookRepository $bookRepository)
    {
    }

    public function index(Request $request): JsonResponse
    {
        $available = $request->input('available');
        $available = $available !== null ? filter_var($available, FILTER_VALIDATE_BOOLEAN) : null;

        return response()->json(
            $this->bookRepository->findAll(new ListBooksFilter(
                $available,
                $request->input('search'),
                $request->input('author'),
            )),
            Response::HTTP_OK
        );
    }

    public function store(StoreBookRequest $request): JsonResponse
    {
        return response()->json(dispatch_sync(new CreateBook(
            title: $request->validated()['title'],
            isbn: $request->validated()['isbn'],
            authorUuid: $request->validated()['author_uuid'])),
            Response::HTTP_CREATED);
    }

    public function show(string $uuid): JsonResponse
    {
        return response()->json(
            $this->bookRepository->requireByUuid($uuid),
            Response::HTTP_OK
        );
    }

    public function borrow(string $uuid, BorrowerNameRequest $request): JsonResponse
    {
        return response()->json(
            dispatch_sync(new BorrowBook($uuid, (string) $request->string('borrower_name'))),
            Response::HTTP_OK);
    }

    public function return(string $uuid): JsonResponse
    {
        return response()->json(dispatch_sync(new ReturnBook($uuid)), Response::HTTP_OK);
    }
}
