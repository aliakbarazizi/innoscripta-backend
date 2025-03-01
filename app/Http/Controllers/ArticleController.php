<?php

namespace App\Http\Controllers;

use App\Http\Actions\Articles\GetArticlesPaginate;
use App\Http\Actions\Articles\GetUserFeedArticlesPaginate;
use App\Http\Requests\ArticleSearchRequest;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use App\Models\User;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(GetArticlesPaginate $getArticlesPaginate, ArticleSearchRequest $request): ResourceCollection
    {
        return ArticleResource::collection($getArticlesPaginate->handle(
            query: $request->validated('query'),
            sources: $request->validated('sources'),
            categories: $request->validated('categories'),
            authors: $request->validated('authors')
        ));
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article): ArticleResource
    {
        return new ArticleResource($article);
    }

    public function feed(GetUserFeedArticlesPaginate $getUserFeedArticlesPaginate): ResourceCollection
    {
        /** @var User $user */
        $user = \Auth::user();

        return ArticleResource::collection($getUserFeedArticlesPaginate->handle($user));
    }
}
