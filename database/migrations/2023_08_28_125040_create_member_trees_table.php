<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('member_trees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable();
            $table->foreignId('sponsor_id')->nullable();
            $table->foreignId('placement_id')->nullable();
            $table->foreignId('incentive_id')->nullable();
            $table->foreignId('step_id')->nullable();
            $table->foreignId('l_id')->nullable();
            $table->foreignId('c_id')->nullable();
            $table->foreignId('r_id')->nullable();
            $table->decimal('l_member', 20)->default('0');
            $table->decimal('c_member', 20)->default('0');
            $table->decimal('r_member', 20)->default('0');
            $table->decimal('total_member', 20)->default('0');
            $table->decimal('l_premium', 20)->default('0');
            $table->decimal('c_premium', 20)->default('0');
            $table->decimal('r_premium', 20)->default('0');
            $table->decimal('total_premium', 20)->default('0');
            $table->decimal('p_point', 20, 2)->default('0');
            $table->decimal('l_point', 20, 2)->default('0');
            $table->decimal('c_point', 20, 2)->default('0');
            $table->decimal('r_point', 20, 2)->default('0');
            $table->decimal('total_point', 20, 2)->default('0');
            $table->decimal('total_matching', 20, 2)->default('0');
            $table->decimal('paid_matching', 20, 2)->default('0');
            $table->decimal('flash_matching', 20, 2)->default('0');
            $table->date('last_matching')->nullable();
            $table->date('last_incentive')->nullable();
            $table->date('incentive_start')->nullable();
            $table->timestamp('is_premium')->nullable();
            $table->timestamp('is_valid')->nullable();
            $table->timestamp('is_founder')->nullable();
            $table->timestamp('is_cashback')->nullable();
            $table->json('details')->nullable();
            $table->foreignId('package_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('member_trees');
    }
};