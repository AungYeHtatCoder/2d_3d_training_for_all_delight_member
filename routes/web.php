<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\User\WalletController;
use App\Http\Controllers\User\WelcomeController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\User\WithDrawController;
use App\Http\Controllers\Admin\PlayTwoDController;
use App\Http\Controllers\Admin\TwoDigitController;
use App\Http\Controllers\User\UserWalletController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\TwoDWinnerController;
use App\Http\Controllers\Admin\FillBalanceController;
use App\Http\Controllers\Admin\TwoDLotteryController;
use App\Http\Controllers\Admin\ThreedHistoryController;
use App\Http\Controllers\User\ChangePasswordController;
use App\Http\Controllers\Admin\ThreedMatchTimeController;
use App\Http\Controllers\Admin\FillBalanceReplyController;
use App\Http\Controllers\Admin\TwoDEveningWinnerController;
use App\Http\Controllers\Admin\TwoDWinnerHistoryController;

// Route::get('/', function () {
//     return view('two_d.api_test');
// });



Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/', [App\Http\Controllers\User\WelcomeController::class, 'index'])->name('welcome');

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'App\Http\Controllers\Admin', 'middleware' => ['auth']], function () {

  // Permissions
  Route::delete('permissions/destroy', [PermissionController::class, 'massDestroy'])->name('permissions.massDestroy');
  Route::resource('permissions', PermissionController::class);
  // Roles
  Route::delete('roles/destroy', [RolesController::class, 'massDestroy'])->name('roles.massDestroy');
  Route::resource('roles', RolesController::class);
  // Users
  Route::delete('users/destroy', [UsersController::class, 'massDestroy'])->name('users.massDestroy');
  Route::resource('users', UsersController::class);
  Route::get('/two-d-users', [App\Http\Controllers\Admin\TwoUsersController::class, 'index'])->name('two-d-users-index');
  // details route
  Route::get('/two-d-users/{id}', [App\Http\Controllers\Admin\TwoUsersController::class, 'show'])->name('two-d-users-details');
  //Banners
  Route::resource('banners', BannerController::class);
  // profile resource rotues
  Route::resource('profiles', ProfileController::class);
  // user profile route get method
  Route::put('/change-password', [ProfileController::class, 'newPassword'])->name('changePassword');
  // PhoneAddressChange route with auth id route with put method
  Route::put('/change-phone-address', [ProfileController::class, 'PhoneAddressChange'])->name('changePhoneAddress');
  Route::put('/change-kpay-no', [ProfileController::class, 'KpayNoChange'])->name('changeKpayNo');
  Route::put('/change-join-date', [ProfileController::class, 'JoinDate'])->name('addJoinDate');
  Route::resource('play-twod', PlayTwoDController::class);
  Route::get('/get-two-d', [App\Http\Controllers\Admin\TwoDPlayController::class, 'GetTwoDigit'])->name('GetTwoDigit');
  Route::post('lotteries-two-d-play', [TwoDigitController::class, 'store'])->name('StorePlayTwoD');
  Route::get('/morning-play-two-d', [App\Http\Controllers\Admin\TwoDPlayController::class, 'MorningPlayTwoDigit'])->name('MorningPlayTwoDigit');

  Route::get('/evening-play-two-d', [App\Http\Controllers\Admin\TwoDPlayController::class, 'EveningPlayTwoDigit'])->name('EveningPlayTwoDigit');

  Route::post('lotteries-two-d-play', [TwoDigitController::class, 'store'])->name('StorePlayTwoD');

  Route::get('/get-three-d', [App\Http\Controllers\Admin\ThreeDPlayController::class, 'GetThreeDigit'])->name('GetThreeDigit');
  Route::get('/three-d-play', [App\Http\Controllers\Admin\ThreeDPlayController::class, 'ThreeDigitPlay'])->name('ThreeDigitPlay');
  Route::get('/three-d-play-confirm', [App\Http\Controllers\Admin\ThreeDPlayController::class, 'ThreeDigitPlayConfirm'])->name('ThreeDigitPlayConfirm');
  Route::get('/three-d-play-confirm-api-format', [App\Http\Controllers\Admin\ThreeDPlayController::class, 'ThreeDigitPlayConfirmApi'])->name('ThreeDigitPlayConfirmApi');
  
  Route::post('/three-digit-play-confirm', [App\Http\Controllers\Admin\ThreeDigitPlayController::class, 'ThreeDigitPlaystore'])->name('ThreeDigitPlaystore');
  
  Route::post('/two-d-play', [App\Http\Controllers\Admin\TwoDPlayController::class, 'store'])->name('two-d-play.store');

  Route::get('/quick-morning-play-two-d', [App\Http\Controllers\Admin\TwoDPlayController::class, 'QuickMorningPlayTwoDigit'])->name('QuickMorningPlayTwoDigit');
  Route::get('/quick-odd-morning-play-two-d', [App\Http\Controllers\Admin\TwoDPlayController::class, 'QuickOddMorningPlayTwoDigit'])->name('QuickOddMorningPlayTwoDigit');
  Route::get('/quick-even-morning-play-two-d', [App\Http\Controllers\Admin\TwoDPlayController::class, 'QuickEvenMorningPlayTwoDigit'])->name('QuickEvenMorningPlayTwoDigit');

  Route::get('/quick-odd-same-morning-play-two-d', [App\Http\Controllers\Admin\TwoDPlayController::class, 'QuickOddSameMorningPlayTwoDigit'])->name('QuickOddSameMorningPlayTwoDigit');

  Route::get('/quick-even-same-morning-play-two-d', [App\Http\Controllers\Admin\TwoDPlayController::class, 'QuickEvenSameMorningPlayTwoDigit'])->name('QuickEvenSameMorningPlayTwoDigit');
  Route::post('/quick-two-d-play', [App\Http\Controllers\Admin\TwoDPlayController::class, 'Quickstore'])->name('Quickstore');
  Route::get('/two-d-play-noti', [App\Http\Controllers\Admin\GetNotificationTwoDPlayUserController::class, 'index'])->name('two-d-play-noti');
  Route::post('/two-d-play-noti-mark-as-read', [App\Http\Controllers\Admin\GetNotificationTwoDPlayUserController::class, 'playTwoDmarkNotification'])->name('playTwoDmarkNotification');

  Route::get('/get-two-d-session-reset', [App\Http\Controllers\Admin\SessionResetControlller::class, 'index'])->name('SessionResetIndex');
  Route::post('/two-d-session-reset', [App\Http\Controllers\Admin\SessionResetControlller::class, 'SessionReset'])->name('SessionReset');
  Route::get('/close-two-d', [App\Http\Controllers\Admin\CloseTwodController::class, 'index'])->name('CloseTwoD');
  Route::put('/update-open-close-two-d', [App\Http\Controllers\Admin\CloseTwodController::class, 'update'])->name('OpenCloseTwoD');
  Route::resource('twod-records', TwoDLotteryController::class);
  Route::resource('tow-d-win-number', TwoDWinnerController::class);
  Route::resource('tow-d-morning-number', TwoDMorningController::class);
  Route::get('/two-d-morning-winner', [App\Http\Controllers\Admin\TwoDMorningWinnerController::class, 'TwoDMorningWinner'])->name('morningWinner');
  Route::get('/two-d-evening-number', [App\Http\Controllers\Admin\TwoDMorningController::class, 'EveningTwoD'])->name('eveningNumber');
  Route::get('/two-d-evening-winner', [App\Http\Controllers\Admin\TwoDMorningController::class, 'TwoDEveningWinner'])->name('eveningWinner');
  Route::get('/two-d-evening-winner', [App\Http\Controllers\Admin\TwoDEveningWinnerController::class, 'TwoDEveningWinner'])->name('eveningWinner');
  Route::get('profile/fill_money', [ProfileController::class, 'fillmoney']);
  // kpay fill money get route
  Route::get('profile/kpay_fill_money', [ProfileController::class, 'index'])->name('kpay_fill_money');
  Route::resource('fill-balance-replies', FillBalanceReplyController::class);
  Route::get('/daily-income-json', [App\Http\Controllers\Admin\DailyTwodIncomeOutComeController::class, 'getTotalAmounts'])->name('dailyIncomeJson');
  Route::get('/with-draw-view', [App\Http\Controllers\Admin\WithDrawViewController::class, 'index'])->name('withdrawViewGet');
  Route::get('/with-draw-details/{id}', [App\Http\Controllers\Admin\WithDrawViewController::class, 'show'])->name('withdrawViewDetails');
  // withdraw update route
  Route::put('/with-draw-update/{id}', [App\Http\Controllers\Admin\WithDrawViewController::class, 'update'])->name('withdrawViewUpdate');
  Route::get('/daily-with-name-income-json', [App\Http\Controllers\Admin\DailyTwodIncomeOutComeController::class, 'getTotalAmountsDaily'])->name('getTotalAmountsDaily');
  // week name route
  Route::get('/weekly-income-json', [App\Http\Controllers\Admin\DailyTwodIncomeOutComeController::class, 'getTotalAmountsWeekly'])->name('getTotalAmountsWeekly');
  // month name route
  Route::get('/month-with-name-income-json', [App\Http\Controllers\Admin\DailyTwodIncomeOutComeController::class, 'getTotalAmountsMonthly'])->name('getTotalAmountsMonthly');
  // year name route
  Route::get('/yearly-income-json', [App\Http\Controllers\Admin\DailyTwodIncomeOutComeController::class, 'getTotalAmountsYearly'])->name('getTotalAmountsYearly');

  // 3d lottery routes
  Route::get('/threed-lotteries-history', [ThreedHistoryController::class, 'index']);
  Route::get('/threed-lotteries-match-time', [ThreedMatchTimeController::class, 'index']);

    // Permissions
    Route::delete('permissions/destroy', [PermissionController::class, 'massDestroy'])->name('permissions.massDestroy');
    Route::resource('permissions', PermissionController::class);
    // Roles
    Route::delete('roles/destroy', [RolesController::class, 'massDestroy'])->name('roles.massDestroy');
    Route::resource('roles', RolesController::class);
    // Users
    Route::delete('users/destroy', [UsersController::class, 'massDestroy'])->name('users.massDestroy');
    Route::resource('users', UsersController::class);
    Route::get('/two-d-users', [App\Http\Controllers\Admin\TwoUsersController::class, 'index'])->name('two-d-users-index');
    // details route
    Route::get('/two-d-users/{id}', [App\Http\Controllers\Admin\TwoUsersController::class, 'show'])->name('two-d-users-details');
    //Banners
    Route::resource('banners', BannerController::class);
    // profile resource rotues
    Route::resource('profiles', ProfileController::class);
    // user profile route get method
    Route::put('/change-password', [ProfileController::class, 'newPassword'])->name('changePassword');
    // PhoneAddressChange route with auth id route with put method
    Route::put('/change-phone-address', [ProfileController::class, 'PhoneAddressChange'])->name('changePhoneAddress');
    Route::put('/change-kpay-no', [ProfileController::class, 'KpayNoChange'])->name('changeKpayNo');
    Route::put('/change-join-date', [ProfileController::class, 'JoinDate'])->name('addJoinDate');
    Route::resource('play-twod', PlayTwoDController::class);
    Route::get('/get-two-d', [App\Http\Controllers\Admin\TwoDPlayController::class, 'GetTwoDigit'])->name('GetTwoDigit');
    Route::post('lotteries-two-d-play', [TwoDigitController::class, 'store'])->name('StorePlayTwoD');
    Route::get('/morning-play-two-d', [App\Http\Controllers\Admin\TwoDPlayController::class, 'MorningPlayTwoDigit'])->name('MorningPlayTwoDigit');

    Route::get('/evening-play-two-d', [App\Http\Controllers\Admin\TwoDPlayController::class, 'EveningPlayTwoDigit'])->name('EveningPlayTwoDigit');

    Route::post('lotteries-two-d-play', [TwoDigitController::class, 'store'])->name('StorePlayTwoD');
    
    Route::post('/two-d-play', [App\Http\Controllers\Admin\TwoDPlayController::class, 'store'])->name('two-d-play.store');

    Route::get('/quick-morning-play-two-d', [App\Http\Controllers\Admin\TwoDPlayController::class, 'QuickMorningPlayTwoDigit'])->name('QuickMorningPlayTwoDigit');
    Route::get('/quick-odd-morning-play-two-d', [App\Http\Controllers\Admin\TwoDPlayController::class, 'QuickOddMorningPlayTwoDigit'])->name('QuickOddMorningPlayTwoDigit');
    Route::get('/quick-even-morning-play-two-d', [App\Http\Controllers\Admin\TwoDPlayController::class, 'QuickEvenMorningPlayTwoDigit'])->name('QuickEvenMorningPlayTwoDigit');

    Route::get('/quick-odd-same-morning-play-two-d', [App\Http\Controllers\Admin\TwoDPlayController::class, 'QuickOddSameMorningPlayTwoDigit'])->name('QuickOddSameMorningPlayTwoDigit');

    Route::get('/quick-even-same-morning-play-two-d', [App\Http\Controllers\Admin\TwoDPlayController::class, 'QuickEvenSameMorningPlayTwoDigit'])->name('QuickEvenSameMorningPlayTwoDigit');
    Route::post('/quick-two-d-play', [App\Http\Controllers\Admin\TwoDPlayController::class, 'Quickstore'])->name('Quickstore');
    Route::get('/two-d-play-noti', [App\Http\Controllers\Admin\GetNotificationTwoDPlayUserController::class, 'index'])->name('two-d-play-noti');
    Route::post('/two-d-play-noti-mark-as-read', [App\Http\Controllers\Admin\GetNotificationTwoDPlayUserController::class, 'playTwoDmarkNotification'])->name('playTwoDmarkNotification');

    Route::get('/get-two-d-session-reset', [App\Http\Controllers\Admin\SessionResetControlller::class, 'index'])->name('SessionResetIndex');
    Route::post('/two-d-session-reset', [App\Http\Controllers\Admin\SessionResetControlller::class, 'SessionReset'])->name('SessionReset');
    Route::get('/close-two-d', [App\Http\Controllers\Admin\CloseTwodController::class, 'index'])->name('CloseTwoD');
    Route::put('/update-open-close-two-d', [App\Http\Controllers\Admin\CloseTwodController::class, 'update'])->name('OpenCloseTwoD');
    Route::resource('twod-records', TwoDLotteryController::class);
    Route::resource('tow-d-win-number', TwoDWinnerController::class);
    Route::resource('tow-d-morning-number', TwoDMorningController::class);
    Route::get('/two-d-morning-winner', [App\Http\Controllers\Admin\TwoDMorningWinnerController::class, 'TwoDMorningWinner'])->name('morningWinner');
    Route::get('/two-d-evening-number', [App\Http\Controllers\Admin\TwoDMorningController::class, 'EveningTwoD'])->name('eveningNumber');
    Route::get('/two-d-evening-winner', [App\Http\Controllers\Admin\TwoDMorningController::class, 'TwoDEveningWinner'])->name('eveningWinner');
    Route::get('/two-d-evening-winner', [App\Http\Controllers\Admin\TwoDEveningWinnerController::class, 'TwoDEveningWinner'])->name('eveningWinner');
    Route::get('profile/fill_money', [ProfileController::class, 'fillmoney']);
    // kpay fill money get route
    Route::get('profile/kpay_fill_money', [ProfileController::class, 'index'])->name('kpay_fill_money');
    Route::resource('fill-balance-replies', FillBalanceReplyController::class);
    Route::get('/daily-income-json', [App\Http\Controllers\Admin\DailyTwodIncomeOutComeController::class, 'getTotalAmounts'])->name('dailyIncomeJson');
    Route::get('/with-draw-view', [App\Http\Controllers\Admin\WithDrawViewController::class, 'index'])->name('withdrawViewGet');
    Route::get('/with-draw-details/{id}', [App\Http\Controllers\Admin\WithDrawViewController::class, 'show'])->name('withdrawViewDetails');
    // withdraw update route
    Route::put('/with-draw-update/{id}', [App\Http\Controllers\Admin\WithDrawViewController::class, 'update'])->name('withdrawViewUpdate');
    Route::get('/daily-with-name-income-json', [App\Http\Controllers\Admin\DailyTwodIncomeOutComeController::class, 'getTotalAmountsDaily'])->name('getTotalAmountsDaily');
    // week name route
    Route::get('/weekly-income-json', [App\Http\Controllers\Admin\DailyTwodIncomeOutComeController::class, 'getTotalAmountsWeekly'])->name('getTotalAmountsWeekly');
    // month name route
    Route::get('/month-with-name-income-json', [App\Http\Controllers\Admin\DailyTwodIncomeOutComeController::class, 'getTotalAmountsMonthly'])->name('getTotalAmountsMonthly');
    // year name route
    Route::get('/yearly-income-json', [App\Http\Controllers\Admin\DailyTwodIncomeOutComeController::class, 'getTotalAmountsYearly'])->name('getTotalAmountsYearly');

    // 3d lottery routes
    Route::get('/threed-lotteries-history', [ThreedHistoryController::class, 'index']);
    Route::get('/threed-lotteries-match-time', [ThreedMatchTimeController::class, 'index']);

});



Route::group(['prefix' => 'user', 'as' => 'user.', 'namespace' => 'App\Http\Controllers\User', 'middleware' => ['auth']], function () {

  /*
    **********
    Write here Client Side Auth Routes
    **********
    */
  

});