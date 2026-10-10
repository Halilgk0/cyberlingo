<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * XP a learner earned outside of finishing a mission, such as a daily review session.
     * It is summed alongside mission XP for the total, the daily goal and the streak.
     */
    public function up(): void
    {
        Schema::create('xp_awards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->unsignedSmallInteger('xp');
            $table->string('source', 32);
            $table->timestamps();

            $table->index(['user_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('xp_awards');
    }
};
