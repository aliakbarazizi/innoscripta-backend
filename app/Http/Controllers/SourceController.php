<?php

namespace App\Http\Controllers;

use App\Actions\Sources\GetSourcesPaginate;
use App\Http\Requests\SourceSearchRequest;
use App\Http\Resources\SourceResource;
use App\Models\Source;
use Illuminate\Http\Resources\Json\ResourceCollection;

class SourceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(GetSourcesPaginate $getSourcesPaginate, SourceSearchRequest $request): ResourceCollection
    {
        return SourceResource::collection($getSourcesPaginate->handle(
            query: $request->validated('query')
        ));
    }

    /**
     * Display the specified resource.
     */
    public function show(Source $source): SourceResource
    {
        return new SourceResource($source);
    }
}
