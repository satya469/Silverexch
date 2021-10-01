<?php

use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\User\AccountController;
use App\Http\Controllers\Frontend\User\DashboardController;
use App\Http\Controllers\Frontend\User\ProfileController;
use App\Http\Controllers\Frontend\AccountsController;
use App\Http\Controllers\Frontend\SportsController;
use App\Http\Controllers\Frontend\MyBetsController;
use App\Http\Controllers\Frontend\Auth\LoginController;
/*
 * Frontend Controllers
 * All route names are prefixed with 'frontend.'.
 */
Route::get('/clear-cache', function() {
    Artisan::call('cache:clear');
    return "Cache is cleared";
});
Route::POST('getRules', [HomeController::class, 'getRules'])->name('getRules')->middleware('auth');
Route::get('/getData/{token}', [HomeController::class, 'getdata'])->name('getdata')->middleware('auth');
Route::get('/getDataTennis/{token}', [HomeController::class, 'getdatatennis'])->name('getdatatennis')->middleware('auth');
Route::get('/getDataSoccer/{token}', [HomeController::class, 'getdatasoccer'])->name('getdatasoccer')->middleware('auth');
Route::get('/userchangepassword', [HomeController::class, 'userchangepassword'])->name('userchangepassword')->middleware('auth');
Route::POST('userchangepassword/store', [HomeController::class, 'userchangepasswordstore'])->name('userchangepasswordstore')->middleware('auth');

Route::get('/', [HomeController::class, 'index'])->name('index')->middleware('auth');
Route::get('/crickets', [SportsController::class, 'cricket'])->name('user.dashboard')->middleware('auth');
Route::get('game-list/cricket', [SportsController::class, 'cricket'])->name('game-list.cricket')->middleware('auth');
Route::get('game-detail/{token}', [SportsController::class, 'singles'])->name('game-list.singles')->middleware('auth');

Route::get('game-list/tennis', [SportsController::class, 'tennis'])->name('game-list.tennis')->middleware('auth');
Route::get('game-list/footboll', [SportsController::class, 'footboll'])->name('game-list.footboll')->middleware('auth');

Route::get('game-list/andar-bahar', [SportsController::class, 'andarbahar'])->name('game-list.andar-bahar')->middleware('auth');
Route::get('game-list/poker', [SportsController::class, 'poker'])->name('game-list.poker')->middleware('auth');
Route::get('game-list/7-up-and-down', [SportsController::class, 'updown7'])->name('game-list.7-up-down')->middleware('auth');
Route::get('game-list/32-cards-casino', [SportsController::class, 'cardscasino32'])->name('game-list.32-cards-casino')->middleware('auth');
Route::get('game-list/teenpati-t20', [SportsController::class, 'teenpatit20'])->name('game-list.teenpati-t20')->middleware('auth');
Route::get('game-list/amar-akhbar-anthony', [SportsController::class, 'amarakhbaranthony'])->name('game-list.amar-akhbar-anthony')->middleware('auth');
Route::get('game-list/dragon-tiger', [SportsController::class, 'dragontiger'])->name('game-list.dragon-tiger')->middleware('auth');

Route::get('game-list/live-teenpati', [SportsController::class, 'liveteenpati'])->name('game-list.live-teenpati')->middleware('auth');
Route::POST('game-list/live-teenpati/get', [SportsController::class, 'getcasinoData'])->name('getcasinoData')->middleware('auth');
Route::POST('casino/resultDeclear', [SportsController::class, 'declearCasinoResult'])->name('my-bets.declearCasinoResult')->middleware('auth');

Route::get('accountstatement', [AccountsController::class, 'accountstatement'])->name('accountstatement')->middleware('auth');
Route::POST('accountstatement/get', [AccountsController::class, 'accountstatementList'])->name('account.accountstatementList')->middleware('auth');

Route::get('profitloss', [AccountsController::class, 'profitloss'])->name('profitloss')->middleware('auth');
Route::POST('profit-loss/get', [AccountsController::class, 'profitlossList'])->name('account.profitlossList')->middleware('auth');

Route::get('casinoresult', [AccountsController::class, 'casinoresultreport'])->name('casinoresultreport')->middleware('auth');
Route::POST('casinoresult/get', [AccountsController::class, 'casinoresultreportList'])->name('account.casinoresultreportList')->middleware('auth');

Route::get('bethistory', [AccountsController::class, 'bethistory'])->name('bethistory')->middleware('auth');
Route::POST('bethistory/get', [AccountsController::class, 'bethistoryList'])->name('account.bethistoryList')->middleware('auth');

Route::get('unsetteledbet', [AccountsController::class, 'unsetteledbet'])->name('unsetteledbet')->middleware('auth');
Route::POST('unsetteledbet/get', [AccountsController::class, 'unsetteledbetList'])->name('account.unsetteledbetList')->middleware('auth');

Route::get('changepassword', [HomeController::class, 'changepassword'])->name('changepassword')->middleware('auth');
Route::POST('changepassword/pwStore', [HomeController::class, 'pwStore'])->name('pwStore')->middleware('auth');

Route::get('changebtnvalue', [HomeController::class, 'changebtnvalue'])->name('changebtnvalue')->middleware('auth');
Route::POST('changebtnvalue/btnStore', [HomeController::class, 'btnvaluestore'])->name('btnvaluestore')->middleware('auth');

Route::POST('my-bets/Store', [MyBetsController::class, 'store'])->name('my-bets.store')->middleware('auth');
Route::POST('my-bets/betList', [MyBetsController::class, 'index'])->name('my-bets.list')->middleware('auth');

Route::POST('my-bets/soccerstore', [MyBetsController::class, 'soccerstore'])->name('my-bets.soccerstore')->middleware('auth');
Route::POST('my-bets/spccerbetList', [MyBetsController::class, 'soccerindex'])->name('my-bets.soccerlist')->middleware('auth');
Route::POST('my-bets/getSessionBetList', [MyBetsController::class, 'getsessionsetsata'])->name('my-bets.getSessionBetData')->middleware('auth');

Route::get('/getExBlance', [MyBetsController::class, 'getExBlance'])->name('getExBlance')->middleware('auth');

Route::POST('betLock/userBooks', [MyBetsController::class, 'userBooks'])->name('betLock.userBooks')->middleware('auth');

Route::get('/icehockey', [HomeController::class, 'gamesextra'])->name('game-list.icehockey')->middleware('auth');
Route::get('/volleball', [HomeController::class, 'gamesextra'])->name('game-list.volleball')->middleware('auth');
Route::get('/basketball', [HomeController::class, 'gamesextra'])->name('game-list.basketball')->middleware('auth');
Route::get('/tabletennis', [HomeController::class, 'gamesextra'])->name('game-list.tabletennis')->middleware('auth');
Route::get('/darts', [HomeController::class, 'gamesextra'])->name('game-list.darts')->middleware('auth');
Route::get('/kabdi', [HomeController::class, 'gamesextra'])->name('game-list.kabdi')->middleware('auth');
Route::get('/boxing', [HomeController::class, 'gamesextra'])->name('game-list.boxing')->middleware('auth');
Route::get('/mixedmartialarts', [HomeController::class, 'gamesextra'])->name('game-list.mixedmartialarts')->middleware('auth');
Route::get('/badminton', [HomeController::class, 'gamesextra'])->name('game-list.badminton')->middleware('auth');
Route::get('/motorsport', [HomeController::class, 'gamesextra'])->name('game-list.motorsport')->middleware('auth');
/*
 * These frontend controllers require the user to be logged in
 * All route names are prefixed with 'frontend.'
 * These routes can not be hit if the password is expired
 */
Route::group(['middleware' => ['auth', 'password_expires']], function () {
    Route::group(['namespace' => 'User', 'as' => 'user.'], function () {
        // User Dashboard Specific
//        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('dashboard', [HomeController::class, 'index'])->name('index')->name('dashboard');
        // User Account Specific
        Route::get('account', [AccountController::class, 'index'])->name('account');

        // User Profile Specific
        Route::patch('profile/update', [ProfileController::class, 'update'])->name('profile.update');
    });
});
