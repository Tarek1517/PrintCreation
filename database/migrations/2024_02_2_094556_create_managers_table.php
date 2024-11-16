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
        Schema::create('managers', function (Blueprint $table) {
            $table->id();
            $table->string('name')->index();
            $table->string('phone')->index();
            $table->string('email')->unique()->index();
            $table->string('secondary_phone')->nullable()->index();
            $table->string('secondary_email')->nullable()->index();
            $table->string('whatsapp_number')->nullable()->index();
            $table->string('image')->nullable();
            $table->string('cover_image')->nullable();
            $table->longText('facebook')->nullable();
            $table->longText('twitter')->nullable();
            $table->longText('instagram')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active')->index();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('managers');
    }
};
