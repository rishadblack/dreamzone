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
        Schema::create('brands', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable();
            $table->text('name')->nullable();
            $table->text('description')->nullable();
            $table->bigInteger('sort')->nullable();
            $table->string('image_url', 100)->nullable();
            $table->string('icon', 100)->nullable();
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
        Schema::dropIfExists('brands');
    }
};
