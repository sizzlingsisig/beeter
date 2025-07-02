<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
     Schema::create('posts', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->foreignId('category_id')->nullable()->constrained()->onDelete('cascade');

    $table->foreignId('parent_id')->nullable()->constrained('posts')->onDelete('cascade');

    $table->string('title')->nullable();
    $table->text('content');
    $table->timestamps();
});

    }

    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
