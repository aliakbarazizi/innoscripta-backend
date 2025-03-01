<?php

namespace App\Http\Controllers;

use App\Http\Actions\Categories\GetCategoriesPaginate;
use App\Http\Requests\CategorySearchRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(GetCategoriesPaginate $getCategoriesPaginate, CategorySearchRequest $request): ResourceCollection
    {
        return CategoryResource::collection($getCategoriesPaginate->handle(
            query: $request->validated('query')
        ));
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category): CategoryResource
    {
        return new CategoryResource($category);
    }
}
