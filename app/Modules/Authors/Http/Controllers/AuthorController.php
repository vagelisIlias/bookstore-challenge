<?php

declare(strict_types=1);

namespace App\Modules\Authors\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Modules\Authors\Commands\CommandBus;
use App\Modules\Authors\Http\Request\StoreAuthorRequest;
use App\Modules\Authors\Services\CreateAuthors\CreateAuthorCommand;
use App\Modules\Authors\Services\ListAuthors\ListAuthorsHandler;
use App\Modules\Authors\Services\ListAuthors\ListAuthorsQuery;
use Symfony\Component\HttpFoundation\JsonResponse;

final class AuthorController
{
    public function index(Request $request, ListAuthorsHandler $handler): JsonResponse
    {
        return response()->json(
            $handler->handle(new ListAuthorsQuery((int) $request->query('per_page', 15))),
            Response::HTTP_OK);
    }

    public function store(StoreAuthorRequest $request, CommandBus $bus): JsonResponse
    {
        return response()->json(
            $bus->dispatch(new CreateAuthorCommand($request->validated()['name'])),
            Response::HTTP_CREATED);
    }
}
