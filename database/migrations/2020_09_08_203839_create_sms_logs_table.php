<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSmsLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sms_logs', function (Blueprint $table) {
            $table->id('id');
            $table->foreignId('user_id')->nullable();
            $table->string('sender', 100)->nullable();
            $table->string('to', 100)->nullable();
            $table->string('action', 100)->nullable();
            $table->text('massage')->nullable();
            $table->decimal('value', 20, 2)->default('0');
            $table->text('response')->nullable();
            $table->tinyInteger('status')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sms_logs');
    }
}
