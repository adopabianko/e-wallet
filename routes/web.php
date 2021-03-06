<?php

use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserActivity;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/auth/redirect', function (Request $request) {
    return Socialite::driver($request->sosmed)->redirect();
})->name('auth.redirect');

Route::get('/auth/callback/{sosmed}', function (Request $request) {
    $sosmed = $request->sosmed;
    $user = Socialite::driver($sosmed)->user();

    $user = User::firstOrCreate([
        'email' => $user->email
    ],[
        'name' => $user->name,
        'password' => Hash::make('secret'),
        'token' => Hash::make('email'),
        'register_from' => $sosmed,
    ]);

    Auth::login($user, true);

    $insert = new UserActivity();
    $insert->email = $user->email;
    $insert->action = 'login';
    $insert->save();

    return redirect('home');
});

Route::get('/transaction/withdraw', [App\Http\Controllers\TransactionController::class, 'withdraw'])->name('transaction.withdraw');
Route::post('/transaction/withdraw-store', [App\Http\Controllers\TransactionController::class, 'withdrawStore'])->name('transaction.withdraw-store');
Route::get('/transaction/transfer', [App\Http\Controllers\TransactionController::class, 'transfer'])->name('transaction.transfer');
Route::post('/transaction/transfer-store', [App\Http\Controllers\TransactionController::class, 'transferStore'])->name('transaction.transfer-store');
Route::get('/report/mutasi', [App\Http\Controllers\ReportController::class, 'mutasi'])->name('report.mutasi');
Route::post('/report/mutasi-download', [App\Http\Controllers\ReportController::class, 'mutasiDownload'])->name('report.mutasi-download');
Route::get('/profile/phone-number', [App\Http\Controllers\ProfileController::class, 'phoneNumber'])->name('profile.phone-number');
Route::put('/profile/{id}/update-phone-number', [App\Http\Controllers\ProfileController::class, 'updatePhoneNumber'])->name('profile.update-phone-number');