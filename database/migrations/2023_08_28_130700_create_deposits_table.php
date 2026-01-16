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
        Schema::create('deposits', function (Blueprint $table) {
            $table->id('id');
            $table->foreignId('user_id')->nullable();
            $table->foreignId('paid_by')->nullable();
            $table->foreignId('cancel_by')->nullable();
            $table->foreignId('receive_by')->nullable();
            $table->tinyInteger('wallet_type')->nullable();
            $table->tinyInteger('type')->nullable();
            $table->tinyInteger('payment_method_id')->nullable();
            $table->string('account_no')->nullable();
            $table->string('account_details')->nullable();
            $table->string('payment_details')->nullable();
            $table->decimal('amount', 20, 2);
            $table->decimal('charge', 20, 2)->default('0');
            $table->decimal('vat', 20, 2)->default('0');
            $table->decimal('net_amount', 20, 2);
            $table->json('details')->nullable();
            $table->tinyInteger('status')->nullable();
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
        Schema::dropIfExists('deposits');
    }
};
