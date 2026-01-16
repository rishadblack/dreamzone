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
        Schema::create('funds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable();
            $table->foreignId('balance_id')->nullable();
            $table->foreignId('detached_balance_id')->nullable();
            $table->decimal('amount', 20, 2)->default('0');
            $table->decimal('charge', 20, 2)->default('0');
            $table->decimal('net_amount', 20, 2)->default('0');
            $table->timestamp('is_attached_request')->nullable();
            $table->timestamp('is_attached')->nullable();
            $table->decimal('attached_amount', 20, 2)->default('0');
            $table->timestamp('is_detached_request')->nullable();
            $table->timestamp('is_detached')->nullable();
            $table->decimal('detached_amount', 20, 2)->default('0');
            $table->decimal('total_return', 20, 2)->default('0');
            $table->tinyInteger('status')->nullable();
            $table->json('details')->nullable();
            $table->text('note')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('funds');
    }
};
