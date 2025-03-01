<?php

namespace App\Http\Controllers;

use App\Actions\Authors\GetAuthorsPaginate;
use App\Http\Requests\AuthorSearchRequest;
use App\Http\Resources\AuthorResource;
use App\Models\Author;
use Illuminate\Http\Resources\Json\ResourceCollection;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(GetAuthorsPaginate $getAuthorsPaginate, AuthorSearchRequest $request): ResourceCollection
    {
        return AuthorResource::collection($getAuthorsPaginate->handle(
            query: $request->validated('query')
        ));
    }

    /**
     * Display the specified resource.
     */
    public function show(Author $author): AuthorResource
    {
        return new AuthorResource($author);
    }
}
