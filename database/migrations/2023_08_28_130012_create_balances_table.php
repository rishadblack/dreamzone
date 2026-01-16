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
        Schema::create('balances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable();
            $table->foreignId('parent_id')->nullable();
            $table->foreignId('order_id')->nullable();
            $table->foreignId('withdrawal_id')->nullable();
            $table->foreignId('deposit_id')->nullable();
            $table->foreignId('income_id')->nullable();
            $table->decimal('amount', 20, 2)->default('0');
            $table->decimal('charge', 20, 2)->default('0');
            $table->decimal('net_amount', 20, 2)->default('0');
            $table->tinyInteger('wallet_type')->nullable();
            $table->tinyInteger('type')->nullable();
            $table->tinyInteger('flow')->nullable();
            $table->foreignId('generated_by')->nullable();
            $table->tinyInteger('is_generated')->nullable();
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
        Schema::dropIfExists('balances');
    }
};
