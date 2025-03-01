<?php

namespace App\Http\Actions\Users;

use App\Models\User;

class UpdateUserPreference
{
    public function handle(
        User $user,
        ?array $sources = null,
        ?array $categories = null,
        ?array $authors = null
    ): void {
        $user->preferredSources()->sync($sources ?? []);
        $user->preferredCategories()->sync($categories ?? []);
        $user->preferredAuthors()->sync($authors ?? []);
    }
}
