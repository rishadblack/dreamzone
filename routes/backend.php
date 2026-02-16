<?php

use App\Pages\Backend;
use App\Pages\Backend\Report;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'member', 'as' => 'backend.', 'middleware' => ['auth']], function () {
    Route::get('/', Backend\Dashboard::class)->name('dashboard');
    Route::get('payout', Backend\WithdrawalList::class)->name('withdrawal');
    Route::get('fund', Backend\BalanceList::class)->name('balance');
    Route::get('deposit', Backend\DepositList::class)->name('deposit');
    Route::get('my-investors', Backend\MemberList::class)->name('member_list');
    Route::get('upgrade-list', Backend\UpgradeList::class)->name('upgrade_list');
    Route::get('packages-list', Backend\PackageList::class)->name('package_list');
    Route::get('profile', Backend\Profile::class)->name('profile');
    Route::get('kyc', Backend\Kyc::class)->name('kyc');

    Route::group(['prefix' => 'report', 'as' => 'report.'], function () {
        Route::get('sponsor-history', Report\SponsorReport::class)->name('sponsor_history');
        Route::get('balance-history', Report\BalanceReport::class)->name('balance_history');
        foreach (collect(config('mlm.income_list'))->sortBy('sort') as $key => $item) {
            Route::get($item['name'] . '-income-report', Report\CommonIncomeReport::class)->name($item['name']);
        }
    });
});
