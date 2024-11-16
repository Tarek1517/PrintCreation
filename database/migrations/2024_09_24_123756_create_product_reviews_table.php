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
        Schema::create('product_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->nullable()->constrained('products')->cascadeOnDelete()->cascadeOnUpdate();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->integer('rating')->nullable();
            $table->string('title')->nullable();
            $table->string('author_name')->nullable();
            $table->text('review')->nullable();
            $table->text('answer')->nullable();
            $table->enum('status', ['pending', 'approved', 'canceled'])->default('approved');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_reviews');
    }
};
