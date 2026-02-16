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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->string('name');
            $table->string('email')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->tinyInteger('gender')->nullable();
            $table->string('mobile')->nullable();
            $table->text('address')->nullable();
            $table->string('position')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->foreignId('country_id')->nullable();
            $table->foreignId('division_id')->nullable();
            $table->foreignId('district_id')->nullable();
            $table->foreignId('upazila_id')->nullable();
            $table->string('union')->nullable();
            $table->string('post_code')->nullable();
            $table->string('pin')->nullable();
            $table->string('national_id')->nullable();
            $table->string('national_id_image')->nullable();
            $table->tinyInteger('por_type')->nullable();
            $table->tinyInteger('por_image')->nullable();
            $table->string('father_name')->nullable();
            $table->string('mother_name')->nullable();
            $table->string('spouse_name')->nullable();
            $table->string('nomine_name')->nullable();
            $table->string('nomine_relation')->nullable();
            $table->foreignId('register_by')->nullable();
            $table->timestamp('birth')->nullable();
            $table->string('profile')->nullable();
            $table->string('note')->nullable();
            $table->json('additional_settings')->nullable();
            $table->timestamp('is_agree')->nullable();
            $table->timestamp('is_approve')->nullable();
            $table->timestamp('is_banned')->nullable();
            $table->timestamp('is_not_transferable')->nullable();
            $table->timestamp('is_not_withdrawalable')->nullable();
            $table->timestamp('is_hide_tree')->nullable();
            $table->decimal('free_upgrade', 20, 2)->nullable();
            $table->decimal('sms_balance', 20, 2)->nullable();
            $table->uuid('uuid')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};