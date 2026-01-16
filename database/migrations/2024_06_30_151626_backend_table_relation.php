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
        Schema::table('users', function (Blueprint $table) {
            $table->index(['country_id', 'division_id', 'district_id', 'upazila_id'], 'users_index');

            $table->foreign('country_id')->references('id')->on('countries')->onDelete('set null');
            $table->foreign('division_id')->references('id')->on('divisions')->onDelete('set null');
            $table->foreign('district_id')->references('id')->on('districts')->onDelete('set null');
            $table->foreign('upazila_id')->references('id')->on('upazilas')->onDelete('set null');
        });

        Schema::table('member_trees', function (Blueprint $table) {
            $table->index(['user_id', 'sponsor_id', 'placement_id','l_id', 'c_id', 'r_id','package_id','is_premium', 'is_valid', 'is_founder'], 'member_trees_index');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict');
            $table->foreign('sponsor_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('placement_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('l_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('c_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('r_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('package_id')->references('id')->on('packages')->onDelete('set null');
        });

        Schema::table('packages', function (Blueprint $table) {
            $table->index(['user_id'], 'packages_index');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });


        Schema::table('balances', function (Blueprint $table) {
            $table->index(['user_id', 'parent_id', 'order_id', 'withdrawal_id', 'deposit_id', 'income_id','type', 'flow', 'status'], 'balances_index');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('parent_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('set null');
            $table->foreign('withdrawal_id')->references('id')->on('withdrawals')->onDelete('set null');
            $table->foreign('deposit_id')->references('id')->on('deposits')->onDelete('set null');
            $table->foreign('income_id')->references('id')->on('incomes')->onDelete('set null');
            $table->foreign('generated_by')->references('id')->on('users')->onDelete('set null');
        });

        Schema::table('incomes', function (Blueprint $table) {
            $table->index(['user_id', 'parent_id', 'parent_income_id', 'order_id', 'point_id', 'fund_id', 'statement_id', 'achievement_id', 'withdrawal_id', 'balance_id','type', 'flow', 'status'], 'incomes_index');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('parent_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('parent_income_id')->references('id')->on('incomes')->onDelete('set null');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('set null');
            $table->foreign('point_id')->references('id')->on('points')->onDelete('set null');
            $table->foreign('fund_id')->references('id')->on('funds')->onDelete('set null');
            $table->foreign('statement_id')->references('id')->on('statements')->onDelete('set null');
            $table->foreign('achievement_id')->references('id')->on('achievements')->onDelete('set null');
            $table->foreign('withdrawal_id')->references('id')->on('withdrawals')->onDelete('set null');
            $table->foreign('balance_id')->references('id')->on('balances')->onDelete('set null');
            $table->foreign('generated_by')->references('id')->on('users')->onDelete('set null');
        });

        Schema::table('withdrawals', function (Blueprint $table) {
            $table->index(['user_id', 'paid_by', 'cancel_by', 'receive_by'], 'withdrawals_index');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('paid_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('cancel_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('receive_by')->references('id')->on('users')->onDelete('set null');
        });


        Schema::table('deposits', function (Blueprint $table) {
            $table->index(['user_id', 'paid_by', 'cancel_by', 'receive_by'], 'deposits_index');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('paid_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('cancel_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('receive_by')->references('id')->on('users')->onDelete('set null');
        });

        Schema::table('statements', function (Blueprint $table) {
            $table->index(['user_id'], 'statements_index');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });

        Schema::table('achievements', function (Blueprint $table) {
            $table->index(['user_id'], 'achievements_index');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });

        Schema::table('funds', function (Blueprint $table) {
            $table->index(['user_id', 'balance_id', 'detached_balance_id'], 'funds_index');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('balance_id')->references('id')->on('balances')->onDelete('set null');
            $table->foreign('detached_balance_id')->references('id')->on('balances')->onDelete('set null');
        });

        Schema::table('points', function (Blueprint $table) {
            $table->index(['user_id', 'parent_id', 'order_id', 'order_item_id', 'package_id','type', 'flow', 'status'], 'points_index');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('parent_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('set null');
            $table->foreign('order_item_id')->references('id')->on('order_items')->onDelete('set null');
            $table->foreign('package_id')->references('id')->on('packages')->onDelete('set null');
            $table->foreign('generated_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {


        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['country_id']);
            $table->dropForeign(['division_id']);
            $table->dropForeign(['district_id']);
            $table->dropForeign(['upazila_id']);

            $table->dropIndex('users_index');
        });

        Schema::table('member_trees', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['sponsor_id']);
            $table->dropForeign(['placement_id']);
            $table->dropForeign(['l_id']);
            $table->dropForeign(['c_id']);
            $table->dropForeign(['r_id']);
            $table->dropForeign(['package_id']);

            $table->dropIndex('member_trees_index');
        });

        Schema::table('packages', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropIndex('packages_index');
        });

        Schema::table('balances', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['parent_id']);
            $table->dropForeign(['order_id']);
            $table->dropForeign(['withdrawal_id']);
            $table->dropForeign(['deposit_id']);
            $table->dropForeign(['income_id']);
            $table->dropForeign(['generated_by']);

            $table->dropIndex('balances_index');
        });

        Schema::table('incomes', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['parent_id']);
            $table->dropForeign(['parent_income_id']);
            $table->dropForeign(['order_id']);
            $table->dropForeign(['point_id']);
            $table->dropForeign(['fund_id']);
            $table->dropForeign(['statement_id']);
            $table->dropForeign(['achievement_id']);
            $table->dropForeign(['withdrawal_id']);
            $table->dropForeign(['balance_id']);
            $table->dropForeign(['generated_by']);

            $table->dropIndex('incomes_index');
        });

        Schema::table('withdrawals', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['paid_by']);
            $table->dropForeign(['cancel_by']);
            $table->dropForeign(['receive_by']);

            $table->dropIndex('withdrawals_index');
        });

        Schema::table('deposits', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['paid_by']);
            $table->dropForeign(['cancel_by']);
            $table->dropForeign(['receive_by']);

            $table->dropIndex('deposits_index');
        });

        Schema::table('statements', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropIndex('statements_index');
        });

        Schema::table('achievements', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropIndex('achievements_index');
        });

        Schema::table('funds', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['balance_id']);
            $table->dropForeign(['detached_balance_id']);

            $table->dropIndex('funds_index');
        });

        Schema::table('points', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['parent_id']);
            $table->dropForeign(['order_id']);
            $table->dropForeign(['order_item_id']);
            $table->dropForeign(['package_id']);
            $table->dropForeign(['generated_by']);

            $table->dropIndex('points_index');
        });

    }
};
