<?php

namespace App\Http\Controllers;

use App\Http\Actions\Users\UpdateUserPreference;
use App\Http\Requests\UpdateUserPreferencesRequest;
use Auth;
use Illuminate\Http\JsonResponse;

class PreferenceController extends Controller
{
    public function update(UpdateUserPreference $updateUserPreference, UpdateUserPreferencesRequest $request): JsonResponse
    {
        $user = Auth::user();

        $updateUserPreference->handle(
            user: $user,
            sources: $request->validated('sources'),
            categories: $request->validated('categories'),
            authors: $request->validated('authors'),
        );

        return response()->json([
            'message' => 'Preferences updated successfully',
        ]);
    }
}
