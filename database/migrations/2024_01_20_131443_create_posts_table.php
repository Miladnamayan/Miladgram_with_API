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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('category_id')->references('id')->on('categories')->onDelete('cascade')->onUpdate('cascade');
            $table->string('title')->nullable();
            $table->string('body')->nullable();
            $table->string('picture')->nullable();
            $table->boolean('post_status')->nullable()->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
