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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable();
            $table->foreignId('brand_id')->nullable();
            $table->foreignId('category_id')->nullable();
            $table->string('code', 100)->nullable();
            $table->tinyInteger('type')->nullable();
            $table->text('name')->nullable();
            $table->text('short_description')->nullable();
            $table->text('description')->nullable();
            $table->integer('sort')->nullable();
            $table->text('title')->nullable();
            $table->decimal('point', 20, 2)->default('0.00');
            $table->decimal('price', 20, 6)->default('0.00');
            $table->string('vat', 20)->nullable();
            $table->decimal('vat_amount', 20, 6)->default('0.00');
            $table->string('discount', 20)->nullable();
            $table->decimal('discount_amount', 20, 6)->default('0.00');
            $table->decimal('net_price', 20, 6)->default('0.00');
            $table->tinyInteger('is_featured')->nullable();
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
        Schema::dropIfExists('products');
    }
};
