<?php

use App\Pages\Superadmin\AchievementList;
use App\Pages\Superadmin\BalanceGenerate;
use App\Pages\Superadmin\BalanceList;
use App\Pages\Superadmin\Dashboard;
use App\Pages\Superadmin\DealerList;
use App\Pages\Superadmin\DepositList;
use App\Pages\Superadmin\FundAttachmentList;
use App\Pages\Superadmin\IncomeList;
use App\Pages\Superadmin\MemberHistory;
use App\Pages\Superadmin\MemberList;
use App\Pages\Superadmin\OrderItemList;
use App\Pages\Superadmin\OrderList;
use App\Pages\Superadmin\PackageList;
use App\Pages\Superadmin\PointList;
use App\Pages\Superadmin\Settings;
use App\Pages\Superadmin\StatementList;
use App\Pages\Superadmin\TicketList;
use App\Pages\Superadmin\WithdrawalList;
use App\Pages\Superadmin\WithdrawPay;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'superadmin', 'as' => 'superadmin.', 'middleware' => ['auth', 'role:superadmin']], function () {
    Route::group(['middleware' => ['role:superadmin']], function () {
        Route::get('/', Dashboard::class)->name('dashboard');
        Route::get('settings', Settings::class)->name('settings');
        Route::get('member-list', MemberList::class)->name('member_list');
        Route::get('dealer-list', DealerList::class)->name('dealer_list');
        Route::get('order-list', OrderList::class)->name('order_list');
        Route::get('order-item-list/{id}', OrderItemList::class)->name('order_item_list');
        Route::get('balance-generate', BalanceGenerate::class)->name('balance_generate');
        Route::get('income-list', IncomeList::class)->name('income_list');
        Route::get('achievement-list', AchievementList::class)->name('achievement_list');
        Route::get('package-list', PackageList::class)->name('package_list');
        Route::get('statement-list', StatementList::class)->name('statement_list');
        Route::get('withdrawal-list', WithdrawalList::class)->name('withdrawal_list');
        Route::get('member-history', MemberHistory::class)->name('member_history');
        Route::get('balance-list', BalanceList::class)->name('balance_list');
        Route::get('point-list', PointList::class)->name('point_list');
        Route::get('deposit-list', DepositList::class)->name('deposit_list');
        Route::get('fund-attachment-list', FundAttachmentList::class)->name('fund_attachment_list');
        Route::get('ticket-list', TicketList::class)->name('ticket_list');
    });

    Route::get('withdraw-pay-list', WithdrawPay::class)->name('withdraw_pay');
});