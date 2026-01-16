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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable();
            $table->foreignId('dealer_id')->nullable();
            $table->foreignId('order_id')->nullable();
            $table->foreignId('product_id')->nullable();
            $table->decimal('price', 20, 6)->nullable();
            $table->decimal('quantity', 10)->nullable();
            $table->decimal('subtotal', 20, 6)->nullable();
            $table->decimal('discount_amount', 20, 6)->nullable();
            $table->decimal('vat_amount', 20, 6)->nullable();
            $table->decimal('net_amount', 20, 6)->nullable();
            $table->decimal('point', 20, 2)->nullable();
            $table->decimal('net_point', 20, 2)->nullable();
            $table->tinyInteger('flow')->nullable();
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
        Schema::dropIfExists('order_items');
    }
};