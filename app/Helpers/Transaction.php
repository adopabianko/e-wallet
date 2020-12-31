<?php

use App\Models\Wallet;
use App\Models\User;

if (!function_exists('balance')) {
    function balance() {
        $userId = Auth::user()->id;
        $wallet = Wallet::where('user_id', $userId)->first();

        if ($wallet) {
            $balance = "Rp " . number_format($wallet->balance,0,',','.'). ',-';
        } else {
            $balance = "Rp 0,-";
        }

        return $balance;
    }
}

if (!function_exists('user_data')) {
    function user_data($id) {
        return User::find($id);
    }
}