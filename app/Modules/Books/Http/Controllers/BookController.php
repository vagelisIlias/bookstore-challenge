<?php

declare(strict_types=1);

namespace App\Modules\Books\Http\Controllers;

use App\Modules\Books\Commands\BorrowBookCommand;
use App\Modules\Books\Commands\ReturnBookCommand;
use App\Modules\Books\Http\Request\BorrowerNameRequest;
use App\Modules\Books\Services\ListBooks\ListBooksHandler;
use App\Modules\Books\Services\ListBooks\ListBooksQuery;
use App\Modules\Books\Services\ShowBook\ShowBookHandler;
use App\Modules\Books\Services\ShowBook\ShowBookQuery;
use App\Modules\Commands\CommandBus;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

final class BookController
{
    public function index(Request $request, ListBooksHandler $handler): JsonResponse
    {
        $available = $request->input('available');
        $available = $available !== null ? filter_var($available, FILTER_VALIDATE_BOOLEAN) : null;

        return response()->json(
            $handler->handle(new ListBooksQuery(
                perPage: (int) $request->input('per_page', 10),
                available: $available,
            )),
            Response::HTTP_OK
        );
    }

    public function show(string $uuid, ShowBookHandler $handler): JsonResponse
    {
        return response()->json($handler->handle(new ShowBookQuery($uuid)), Response::HTTP_OK);
    }

    public function borrow(string $uuid, BorrowerNameRequest $request, CommandBus $bus): JsonResponse
    {
        return response()->json(
            $bus->dispatch(new BorrowBookCommand(
                uuid: $uuid,
                borrowerName: $request->validated()['borrower_name'])),
                Response::HTTP_OK);
    }

    public function return(string $uuid, CommandBus $bus): JsonResponse
    {
        return response()->json($bus->dispatch(new ReturnBookCommand($uuid)), Response::HTTP_OK);
    }
}
