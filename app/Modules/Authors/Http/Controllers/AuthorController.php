<?php

declare(strict_types=1);

namespace App\Modules\Authors\Http\Controllers;

use App\Modules\Authors\Commands\CreateAuthor;
use App\Modules\Authors\Database\AuthorRepository;
use App\Modules\Authors\Http\Request\StoreAuthorRequest;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

final class AuthorController
{
    public function index(AuthorRepository $authorRepository): JsonResponse
    {
        return response()->json(
            $authorRepository->findAll(),
            Response::HTTP_OK);
    }

    public function store(StoreAuthorRequest $request): JsonResponse
    {
        return response()->json(
            dispatch_sync(new CreateAuthor((string) $request->string('name'))),
            Response::HTTP_CREATED);
    }
}
