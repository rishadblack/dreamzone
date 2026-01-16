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
        Schema::create('statements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable();
            $table->tinyInteger('type')->nullable();
            $table->json('details')->nullable();
            $table->decimal('fixed', 20, 2)->default('0');
            $table->decimal('percentage', 20, 2)->default('0');
            $table->timestamp('close_date')->nullable();
            $table->timestamp('is_distribute')->nullable();
            $table->decimal('total_amount', 20, 2)->default('0');
            $table->decimal('distribute_amount', 20, 2)->default('0');
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
        Schema::dropIfExists('statements');
    }
};