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
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('name')->index();
            $table->string('phone')->index();
            $table->string('email')->index();
            $table->string('secondary_phone')->nullable()->index();
            $table->string('secondary_email')->nullable()->index();
            $table->string('whatsapp_number')->nullable()->index();
            $table->string('image')->nullable();
            $table->string('cover_image')->nullable();
            $table->string('country');
            $table->string('city');
            $table->string('address');
            $table->string('post_code');
            $table->longText('facebook')->nullable();
            $table->longText('twitter')->nullable();
            $table->longText('instagram')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->boolean('status')->default(true);
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
        Schema::dropIfExists('admins');
    }
};
