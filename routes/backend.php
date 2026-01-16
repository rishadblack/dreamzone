<?php

use App\Pages\Backend\Kyc;
use App\Pages\Backend\Profile;
use App\Pages\Backend\Settings;
use App\Pages\Backend\Dashboard;
use App\Pages\Backend\MemberList;
use App\Pages\Backend\BalanceList;
use App\Pages\Backend\DepositList;
use App\Pages\Backend\UpgradeList;
use App\Pages\Backend\WithdrawalList;
use Illuminate\Support\Facades\Route;
use App\Pages\Backend\Report\BalanceReport;
use App\Pages\Backend\Report\SponsorReport;
use App\Pages\Backend\Report\RoiIncomeReport;
use App\Pages\Backend\Report\SponsorIncomeReport;
use App\Pages\Backend\Report\IncentiveIncomeReport;
use App\Http\Controllers\BackendDatatableController;
use App\Pages\Backend\PackageList;
use App\Pages\Backend\Report\GenerationIncomeReport;

Route::group(['prefix' => 'member', 'as' => 'backend.','middleware' => ['auth']], function () {
    Route::get('/', Dashboard::class)->name('dashboard');
    Route::get('payout', WithdrawalList::class)->name('withdrawal');
    Route::get('fund', BalanceList::class)->name('balance');
    Route::get('deposit', DepositList::class)->name('deposit');
    Route::get('my-investors', MemberList::class)->name('member_list');
    Route::get('upgrade-list', UpgradeList::class)->name('upgrade_list');
    Route::get('packages-list', PackageList::class)->name('package_list');
    Route::get('profile', Profile::class)->name('profile');
    Route::get('kyc', Kyc::class)->name('kyc');

    Route::group(['prefix' => 'report', 'as' => 'report.'], function () {
        Route::get('refer-history', SponsorReport::class)->name('sponsor');
        Route::get('fund-history', BalanceReport::class)->name('balance');
        Route::get('generation-income', GenerationIncomeReport::class)->name('generation_income');
        Route::get('refer-income', SponsorIncomeReport::class)->name('sponsor_income');
        Route::get('roi-income', RoiIncomeReport::class)->name('roi_income');
        Route::get('incentive-income', IncentiveIncomeReport::class)->name('incentive_income');
    });
});
