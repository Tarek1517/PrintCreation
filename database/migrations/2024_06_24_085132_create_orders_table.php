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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('address_id')->nullable();
            $table->string('order_code')->nullable();
            $table->float('sub_total')->nullable();
            $table->float('grand_total')->nullable();
            $table->float('vat')->nullable();
            $table->float('pay_bill')->nullable();
            $table->float('pay_due')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('customer_name')->nullable();
            $table->string('customer_phone')->nullable();
            $table->string('customer_email')->nullable();
            $table->text('customer_address')->nullable();
            $table->float('delivery_charge')->nullable();
            $table->string('shipping_area')->nullable();
            $table->enum('order_type', ['customer', 'pos', 'guest'])->default('customer');
            $table->enum('payment_status', ['paid', 'pending', 'cancelled'])->default("pending");
            $table->enum('order_status', ['pending','received','process','shipped','delivered','cancel'])->default("pending");
            $table->text('status_note')->nullable();
            $table->date('order_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
