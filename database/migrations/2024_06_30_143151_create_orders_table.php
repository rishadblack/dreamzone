<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable();
            $table->foreignId('dealer_id')->nullable();
            $table->tinyInteger('type')->nullable();
            $table->tinyInteger('payment_method_id')->nullable();
            $table->decimal('subtotal', 20, 6)->nullable();
            $table->decimal('discount_amount', 20, 6)->nullable();
            $table->decimal('charge', 20, 6)->nullable();
            $table->decimal('vat_amount', 20, 6)->nullable();
            $table->decimal('net_amount', 20, 6)->nullable();
            $table->decimal('point', 20, 2)->nullable();
            $table->string('delivery_name', 100)->nullable();
            $table->text('delivery_address')->nullable();
            $table->string('delivery_phone', 50)->nullable();
            $table->string('delivery_mobile', 50)->nullable();
            $table->string('delivery_company', 100)->nullable();
            $table->tinyInteger('delivery_status')->nullable();
            $table->tinyInteger('payment_status')->nullable();
            $table->tinyInteger('status')->nullable();
            $table->timestamps();
            $table->softDeletes();
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
