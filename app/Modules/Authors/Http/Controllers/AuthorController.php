<?php

declare(strict_types=1);

namespace App\Modules\Authors\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Modules\Authors\Http\Request\StoreAuthorRequest;
use App\Modules\Authors\Services\ListAuthors\ListAuthorsDto;
use App\Modules\Authors\Services\ListAuthors\ListAuthorsHandler;
use App\Modules\Authors\Services\CreateAuthors\CreateAuthorDto;
use App\Modules\Authors\Services\CreateAuthors\CreateAuthorHandler;

final class AuthorController
{
    public function index(Request $request, ListAuthorsHandler $handler): JsonResponse
    {
        return response()->json($handler->handle(new ListAuthorsDto((int) $request->query('per_page', 15))), Response::HTTP_OK);
    }

    public function store(StoreAuthorRequest $request, CreateAuthorHandler $handler): JsonResponse
    {
        return response()->json($handler->handle(new CreateAuthorDto($request->validated()['name'])), Response::HTTP_CREATED);
    }
}
