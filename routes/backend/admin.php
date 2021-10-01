<?php

use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\ListClientController;
use App\Http\Controllers\Backend\AccountsController;
use App\Http\Controllers\Backend\SportsController;
use App\Http\Controllers\Backend\GamesController;
use App\Http\Controllers\Backend\UserDepositesController;
use App\Http\Controllers\Frontend\Auth\AdminLoginController;
use App\Http\Controllers\Backend\PrivilegeController;
use App\Http\Controllers\Backend\MyBetsController;

// All route names are prefixed with 'admin.'.
//Route::redirect('admin', '/admin/login', 301);
Route::get('admin-setting', [DashboardController::class, 'adminsetting'])->name('admin-setting');
Route::post('admin-setting/store', [DashboardController::class, 'adminsettingstore'])->name('admin-setting.store');

Route::get('manage-tv', [DashboardController::class, 'managetv'])->name('settingTvUrl');
Route::post('manage-tv/store', [DashboardController::class, 'managetvstore'])->name('managetvstore');

Route::get('add-privilege', [DashboardController::class, 'privilege'])->name('admin-setting.privilege');
Route::post('add-privilege/privilegestore', [DashboardController::class, 'privilegestore'])->name('admin-setting.privilegestore');

//Route::get('dashboard', [ListClientController::class, 'listclients'])->name('dashboard')->middleware('auth');
Route::get('list-clients', [ListClientController::class, 'listclients'])->name('list-client')->middleware('auth');
Route::get('add-account', [ListClientController::class, 'addaccount'])->name('add-account')->middleware('auth');
Route::get('min-max-bet/{uuid}', [ListClientController::class, 'minmaxbet'])->name('client.minmaxbet')->middleware('auth');
Route::post('min-max-bet/store/{id}', [ListClientController::class, 'minmaxstore'])->name('client.minmaxstore')->middleware('auth');


Route::post('list-clients/userlimit', [ListClientController::class, 'userlimit'])->name('client.userlimit')->middleware('auth');
Route::post('list-clients/usercredit', [ListClientController::class, 'usercredit'])->name('client.usercredit')->middleware('auth');
Route::post('list-clients/userNameCheck', [ListClientController::class, 'checkusername'])->name('client.checkusername')->middleware('auth');

Route::post('list-clients/getClientDetails', [ListClientController::class, 'getClientDetails'])->name('client.getClientDetails')->middleware('auth');

Route::post('list-clients/withdraw', [ListClientController::class, 'withdraw'])->name('client.withdraw')->middleware('auth');
Route::post('list-clients/deposit', [ListClientController::class, 'deposit'])->name('client.deposit')->middleware('auth');
Route::post('list-clients/depositstore', [UserDepositesController::class, 'store'])->name('client.depositstore')->middleware('auth');
Route::post('list-clients/resultcricketsession', [UserDepositesController::class, 'resultcricketsession'])->name('client.resultcricketsession')->middleware('auth');

Route::post('list-clients/userlimitstore', [ListClientController::class, 'userlimitstore'])->name('client.userlimitstore')->middleware('auth');
Route::post('list-clients/usercreditstore', [ListClientController::class, 'usercreditstore'])->name('client.usercreditstore')->middleware('auth');
Route::post('list-clients/userstatuschange', [ListClientController::class, 'userstatuschange'])->name('client.userstatuschange')->middleware('auth');
Route::post('list-clients/updatePassword', [ListClientController::class, 'updatePassword'])->name('client.updatePassword')->middleware('auth');
Route::post('list-clients/userclientrows', [ListClientController::class, 'userclientrows'])->name('client.userclientrows')->middleware('auth');
Route::post('list-clients/userstatusview', [ListClientController::class, 'userstatusview'])->name('client.userstatusview')->middleware('auth');
Route::post('list-clients/userstatusview', [ListClientController::class, 'userstatusview'])->name('client.userstatusview')->middleware('auth');
Route::get('userchangepassword', [ListClientController::class, 'userchangepassword'])->name('userchangepassword')->middleware('auth');
Route::POST('userchangepasswordstore', [ListClientController::class, 'userchangepasswordstore'])->name('client.userchangepasswordstore')->middleware('auth');
Route::get('list-clients/parent/{uuid}', [ListClientController::class, 'listchild'])->name('client.listchild')->middleware('auth');


Route::get('current-bets', [AccountsController::class, 'currentbets'])->name('currentbets')->middleware('auth');
Route::POST('current-bets/get', [AccountsController::class, 'currentbetsList'])->name('account.currentbetsList')->middleware('auth');

Route::get('account-statement', [AccountsController::class, 'accountstatement'])->name('accountstatement')->middleware('auth');
Route::POST('account-statement/get', [AccountsController::class, 'accountstatementList'])->name('account.accountstatementList')->middleware('auth');
Route::POST('account-statement/getGameDropdownList', [AccountsController::class, 'getGameDropdownList'])->name('account.getGameDropdownList')->middleware('auth');
Route::POST('account-statement/getbetList', [AccountsController::class, 'getbetList'])->name('account.getbetList')->middleware('auth');

Route::get('general-report', [AccountsController::class, 'generalreport'])->name('generalreport')->middleware('auth');
Route::POST('general-report/get', [AccountsController::class, 'generalreportList'])->name('account.generalreport')->middleware('auth');


Route::get('game-report', [AccountsController::class, 'gamereport'])->name('gamereport')->middleware('auth');
Route::get('casino-report', [AccountsController::class, 'casinoreport'])->name('casinoreport')->middleware('auth');
Route::POST('game-report/getgameandfancylist', [AccountsController::class, 'getgameandfancylist'])->name('account.getgameandfancylist')->middleware('auth');
Route::POST('game-report/getgamereportList', [AccountsController::class, 'getgamereportList'])->name('account.getgamereportList')->middleware('auth');

Route::get('profit-loss', [AccountsController::class, 'profitloss'])->name('profitloss')->middleware('auth');
Route::POST('profit-loss/get', [AccountsController::class, 'profitlossList'])->name('account.profitlossList')->middleware('auth');

Route::get('casinoresult', [AccountsController::class, 'casinoresultreport'])->name('casinoresultreport')->middleware('auth');
Route::POST('casinoresult/get', [AccountsController::class, 'casinoresultreportList'])->name('account.casinoresultreportList')->middleware('auth');

Route::get('list-game', [GamesController::class, 'index'])->name('list-game')->middleware('auth');
Route::get('add-game', [GamesController::class, 'create'])->name('add-game')->middleware('auth');
Route::post('add-game/store', [GamesController::class, 'store'])->name('game.store')->middleware('auth');
Route::post('add-game/status', [GamesController::class, 'status'])->name('game.status')->middleware('auth');

Route::get('manage-fancy/cricket', [SportsController::class, 'managefancycricket'])->name('manage_fancy.cricket')->middleware('auth');
Route::get('manage-fancy/Soccer', [SportsController::class, 'managefancysoccer'])->name('manage_fancy.soccer')->middleware('auth');
Route::get('fancy-detail/{matchid}/cricket', [SportsController::class, 'managefancycricketsingle'])->name('manage_fancy.single')->middleware('auth');
Route::get('fancy-detail/{matchid}/soccer', [SportsController::class, 'managefancysoccersingle'])->name('manage_fancy.soccersingle')->middleware('auth');
Route::POST('fancy-detail/Fancyresultrollback', [SportsController::class, 'resultrollbackcricketsession'])->name('sports.resultrollbackcricketsession')->middleware('auth');
Route::POST('fancy-detail/FancyresultrollbackSoccer', [SportsController::class, 'resultrollbackSoccersession'])->name('sports.resultrollbackSoccersession')->middleware('auth');
Route::POST('fancy-detail/Fancyresultcancel', [SportsController::class, 'resultcancelcricketsession'])->name('sports.resultcancelcricketsession')->middleware('auth');
Route::POST('sport/soccer/sesionwinner', [SportsController::class, 'soccersessionwinner'])->name('sports.soccersessionwinner')->middleware('auth');

Route::get('fancy-history/cricket', [SportsController::class, 'fancyhistorycricket'])->name('fancy_history.cricket')->middleware('auth');
Route::get('fancy-history/soccer', [SportsController::class, 'fancyhistorysoccer'])->name('fancy_history.soccer')->middleware('auth');

Route::get('fancy-history/{matchid}/cricket', [SportsController::class, 'managefancyhistorycricketsingle'])->name('manage_history.single')->middleware('auth');
Route::get('fancy-history/{matchid}/soccer', [SportsController::class, 'managefancyhistorysoccersingle'])->name('manage_history.soccersingle')->middleware('auth');
Route::get('match_history_details', [SportsController::class, 'matchhistory'])->name('matchhistory')->middleware('auth');

Route::get('add-sports/{id}', [SportsController::class, 'create'])->name('addSports')->middleware('auth');
Route::get('list-sports/{id}', [SportsController::class, 'index'])->name('listSports')->middleware('auth');
Route::post('add-sports/store', [SportsController::class, 'store'])->name('sports.store')->middleware('auth');
Route::POST('sports/changeStatus', [SportsController::class, 'changestatus'])->name('sports.chnagestatus')->middleware('auth');
Route::POST('sports/setLimit', [SportsController::class, 'setlimit'])->name('sports.setLimit')->middleware('auth');
Route::POST('sports/GeteMinMaxLimit', [SportsController::class, 'getMAxMinLimit'])->name('sports.getMAxMinLimit')->middleware('auth');
Route::POST('sports/chnagesuspened', [SportsController::class, 'chnagesuspened'])->name('sports.chnagesuspened')->middleware('auth');
Route::POST('sports/changeStatusInplay', [SportsController::class, 'chnagestatusInplay'])->name('sports.chnagestatusInplay')->middleware('auth');

Route::POST('sports/winnerselect', [SportsController::class, 'winnerselect'])->name('sports.winnerselect')->middleware('auth');
Route::POST('sports/winnerselect/store', [SportsController::class, 'winnerselectstore'])->name('sports.winnerselectstore')->middleware('auth');
Route::POST('sports/winnerselect/resultrollback', [SportsController::class, 'resultrollback'])->name('sports.resultrollback')->middleware('auth');

Route::POST('sports/winnersoccer/store', [SportsController::class, 'winnerselectstore'])->name('sports.winnerselectstore')->middleware('auth');


Route::get('listPrivilege', [PrivilegeController::class, 'index'])->name('privilige.list')->middleware('auth');
Route::POST('addnewprivilege/store', [PrivilegeController::class, 'store'])->name('privilige.store')->middleware('auth');
Route::POST('addnewprivilege/storeprivilege', [PrivilegeController::class, 'storeprivilege'])->name('privilige.storePrivilege')->middleware('auth');
Route::POST('addnewprivilege/deleteprivilege', [PrivilegeController::class, 'destroy'])->name('privilige.deletePrivilege')->middleware('auth');
Route::POST('addnewprivilege/editprivilege', [PrivilegeController::class, 'editprivilege'])->name('privilige.editprivilege')->middleware('auth');
Route::POST('addnewprivilege/updateprivilege', [PrivilegeController::class, 'update'])->name('privilige.updateprivilege')->middleware('auth');

Route::get('market-analysis', [SportsController::class, 'marketanalysis'])->name('marketanalysis')->middleware('auth');
Route::get('dashboard', [SportsController::class, 'marketanalysis'])->name('dashboard')->middleware('auth');
Route::get('market-details', [SportsController::class, 'marketanalysisdetails'])->name('marketanalysisdetails')->middleware('auth');
Route::get('market-analysis/{token}/cricket', [SportsController::class, 'MADCricket'])->name('MADCricket')->middleware('auth');
Route::get('market-analysis/{token}/soccer', [SportsController::class, 'MADSoccer'])->name('MADSoccer')->middleware('auth');
Route::get('market-analysis/{token}/tennis', [SportsController::class, 'MADTennis'])->name('MADTennis')->middleware('auth');

Route::POST('my-bets/betList', [MyBetsController::class, 'index'])->name('my-bets.list')->middleware('auth');
Route::POST('my-bets/spccerbetList', [MyBetsController::class, 'soccerindex'])->name('my-bets.soccerlist')->middleware('auth');
Route::POST('my-bets/getSessionBetList', [MyBetsController::class, 'getsessionsetsata'])->name('my-bets.getSessionBetData')->middleware('auth');

Route::POST('my-bets/delete', [MyBetsController::class, 'deleteMyBet'])->name('my-bets.deleteMyBet')->middleware('auth');
Route::POST('my-bets/rollback', [MyBetsController::class, 'rollBackMyBet'])->name('my-bets.rollBackMyBet')->middleware('auth');

Route::get('live-teenpati', [SportsController::class, 'liveteenpati'])->name('live-teenpati')->middleware('auth');
Route::get('andar-bahar', [SportsController::class, 'andarbahar'])->name('andar-bahar')->middleware('auth');
Route::get('poker', [SportsController::class, 'poker'])->name('poker')->middleware('auth');
Route::get('7-up-and-down', [SportsController::class, 'updown7'])->name('7-up-down')->middleware('auth');
Route::get('32-cards-casino', [SportsController::class, 'cardscasino32'])->name('32-cards-casino')->middleware('auth');
Route::get('teenpati-t20', [SportsController::class, 'teenpatit20'])->name('teenpati-t20')->middleware('auth');
Route::get('amar-akhbar-anthony', [SportsController::class, 'amarakhbaranthony'])->name('amar-akhbar-anthony')->middleware('auth');
Route::get('dragon-tiger', [SportsController::class, 'dragontiger'])->name('dragon-tiger')->middleware('auth');

/** BET LOCK UNLOCK BET MODEL ***/

Route::POST('betLock/lockUnlock', [SportsController::class, 'lockUnlock'])->name('betLock.lockUnlock')->middleware('auth');
Route::POST('betLock/getUserList', [SportsController::class, 'getUserList'])->name('betLock.getUserList')->middleware('auth');

Route::post('checkLoginUser', [ListClientController::class, 'checkLoginUser'])->name('checkLoginUser')->middleware('auth');

Route::POST('my-bets/viewMoreBets', [MyBetsController::class, 'viewMoreBets'])->name('viewMoreBets')->middleware('auth');
Route::POST('my-bets/viewMoreBetsSearch', [MyBetsController::class, 'viewMoreBetsAll'])->name('viewMoreBetsSearch')->middleware('auth');
