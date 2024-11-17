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
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            $table->foreignId('category_id')
            ->constrained('categories')
            ->cascadeOnDelete()
            ->cascadeOnUpdate();

            $table->unsignedBigInteger('brand_id')
            ->nullable();

            $table->unsignedBigInteger('created_by')
            ->nullable();

            $table->json('variations')->nullable();
            $table->json('variationOptions')->nullable();

            $table->string('title')->index();
            $table->string('slug');
            $table->string('cover_image');
            $table->string('hover_image')->nullable();
            $table->longText('video_url')->nullable();
			$table->text('short_description')->nullable();
            $table->double('price')->default(0);
            $table->double('discount_price')->default(0);
            $table->string('sku')->nullable();
            $table->string('bar_code')->nullable();
			$table->string('stock')->nullable();
            $table->json('key_features')->nullable();
            $table->longText('product_info')->nullable();
            $table->longText('specification')->nullable();
			$table->boolean('is_variant')->default(false);
            $table->integer('visited')->default(0);
			$table->boolean('attachment')->default(false);
			$table->enum('attachment_type', ['text', 'image', 'both'])->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
