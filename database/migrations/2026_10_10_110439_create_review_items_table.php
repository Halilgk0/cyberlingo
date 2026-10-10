<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * A learner's "mistake notebook": quiz questions they got wrong, kept so the app can
     * resurface them a day later. `key` identifies the question; `data` holds a snapshot of
     * it so a review can be shown without the original mission.
     */
    public function up(): void
    {
        Schema::create('review_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('key', 80);
            $table->json('data');
            $table->date('due_on');
            $table->timestamps();

            $table->unique(['user_id', 'key']);
            $table->index(['user_id', 'due_on']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('review_items');
    }
};
