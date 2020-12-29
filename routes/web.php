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