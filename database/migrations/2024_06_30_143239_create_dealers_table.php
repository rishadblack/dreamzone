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
        Schema::create('dealers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable();
            $table->tinyInteger('type')->nullable();
            $table->string('business_name')->nullable();
            $table->string('mobile')->nullable();
            $table->string('email')->nullable();
            $table->string('address')->nullable();
            $table->string('post_code')->nullable();
            $table->foreignId('country_id')->nullable();
            $table->foreignId('division_id')->nullable();
            $table->foreignId('district_id')->nullable();
            $table->foreignId('upazila_id')->nullable();
            $table->string('union')->nullable();
            $table->tinyInteger('is_banned_cod')->nullable();
            $table->tinyInteger('is_banned_balance')->nullable();
            $table->tinyInteger('is_office')->nullable();
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
        Schema::dropIfExists('dealers');
    }
};