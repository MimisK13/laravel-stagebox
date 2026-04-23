<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stageboxes', function (Blueprint $table): void {
            $table->id();
            $table->morphs('stageboxable');
            $table->string('name');
            $table->string('slug');
            $table->unsignedTinyInteger('channels')->default(12);
            $table->unsignedTinyInteger('returns')->default(0);
            $table->string('color')->default('black');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique(['stageboxable_type', 'stageboxable_id', 'slug']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stageboxes');
    }
};
