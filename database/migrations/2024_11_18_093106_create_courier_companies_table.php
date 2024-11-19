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
        Schema::create('courier_companies', function (Blueprint $table) {
            $table->id();
			$table->string('company_name')->unique();
			$table->string('company_logo')->nullable();
			$table->integer('delivery_charge');
			$table->text('api_key')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courier_companies');
    }
};
