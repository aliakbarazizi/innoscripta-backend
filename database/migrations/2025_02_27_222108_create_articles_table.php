<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();

            $table->text('title');
            $table->longText('content');
            $table->text('thumbnail')->nullable();
            $table->text('url');
            $table->timestamp('published_at')->index();

            $table->foreignId('author_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('source_id')->constrained()->cascadeOnDelete();
            $table->foreignId('category_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('provider');

            $table->fullText(['title', 'content']);

            $table->index(['provider', 'published_at']);
            // we need to know which composite index works better base on usage
            $table->index(['source_id', 'category_id', 'author_id', 'published_at']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
