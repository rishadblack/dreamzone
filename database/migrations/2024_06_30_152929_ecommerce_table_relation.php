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
        Schema::table('products', function (Blueprint $table) {
            $table->index(['user_id', 'brand_id', 'category_id', 'type', 'is_featured'], 'products_index');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('brand_id')->references('id')->on('brands')->onDelete('set null');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');
        });


        Schema::table('categories', function (Blueprint $table) {
            $table->index(['user_id'], 'categories_index');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });


        Schema::table('brands', function (Blueprint $table) {
            $table->index(['user_id'], 'brands_index');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->index(['user_id', 'dealer_id'], 'order_index');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('dealer_id')->references('id')->on('dealers')->onDelete('set null');
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->index(['user_id', 'dealer_id', 'order_id', 'product_id'], 'order_item_index');
            $table->index(['flow', 'status']);

            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('dealer_id')->references('id')->on('dealers')->onDelete('set null');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('set null');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('set null');
        });

        Schema::table('dealers', function (Blueprint $table) {
            $table->index(['user_id','country_id', 'division_id', 'district_id', 'upazila_id'], 'dealers_index');

            $table->foreign('country_id')->references('id')->on('countries')->onDelete('set null');
            $table->foreign('division_id')->references('id')->on('divisions')->onDelete('set null');
            $table->foreign('district_id')->references('id')->on('districts')->onDelete('set null');
            $table->foreign('upazila_id')->references('id')->on('upazilas')->onDelete('set null');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::table('product_images', function (Blueprint $table) {
            $table->index(['user_id', 'product_id'], 'product_image_index');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('set null');
        });




    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['brand_id']);
            $table->dropForeign(['category_id']);

            $table->dropIndex('products_index');
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->dropForeign(['user_id']);

            $table->dropIndex('categories_index');
        });

        Schema::table('brands', function (Blueprint $table) {
            $table->dropForeign(['user_id']);

            $table->dropIndex('brands_index');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['dealer_id']);

            $table->dropIndex('order_index');
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['dealer_id']);
            $table->dropForeign(['order_id']);
            $table->dropForeign(['product_id']);

            $table->dropIndex('order_item_index');
        });

        Schema::table('dealers', function (Blueprint $table) {
            $table->dropForeign(['user_id']);

            $table->dropIndex('dealers_index');
        });

        Schema::table('product_images', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['product_id']);

            $table->dropIndex('product_image_index');
        });
    }
};