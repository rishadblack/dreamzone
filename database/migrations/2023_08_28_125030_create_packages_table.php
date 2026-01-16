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
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable();
            $table->string('name')->nullable();
            $table->text('details')->nullable();
            $table->decimal('flash_condition', 20, 2)->default('0')->nullable();
            $table->decimal('point_value', 20, 2)->default('0')->nullable();
            $table->decimal('amount', 20, 2)->default('0')->nullable();
            $table->decimal('to_amount', 20, 2)->default('0')->nullable();
            $table->tinyInteger('type')->nullable();
            $table->tinyInteger('is_default')->nullable();
            $table->tinyInteger('status')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
