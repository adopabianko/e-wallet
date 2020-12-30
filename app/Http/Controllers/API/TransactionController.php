<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Wallet;
use App\Models\User;
use DB;
use Validator;

class TransactionController extends Controller
{
    public function topup(Request $request) {
        $v = Validator::make($request->all(), [
            'phone_number' => 'required|numeric',
            'bank_code' => 'required',
            'amount' => 'required|numeric',
        ]);

        if ($v->fails()) {
            return response()->json([
                "code" => 422,
                "message" => $v->messages()->first()
            ], 422);
       }

        $phoneNumber = $request->phone_number;
        $bankCode = $request->bank_code;
        $amount = $request->amount;
        
        DB::beginTransaction();

        try {
            // Get User ID
            $userId = User::select('id')->where('phone_number', $phoneNumber)->first();

            if (!$userId) {
                return response()->json([
                    "code" => 404,
                    "message" => "Phone Number is not found",
                ], 404);
            }

            // Get Balance
            $balanceWallet = Wallet::select(DB::raw(' COALESCE(balance, 0) as balance'))
                ->where('user_id', $userId->id)
                ->first();

            if (!$balanceWallet) {
                $newBalanceWallet = $amount;

                $wallet = new Wallet();
                $wallet->user_id = $userId->id;
                $wallet->balance = $newBalanceWallet;
                $wallet->save();
            } else {
                $newBalanceWallet = $amount + $balanceWallet->balance;

                $wallet = Wallet::find($userId->id);
                $wallet->user_id = $userId->id;
                $wallet->balance = $newBalanceWallet;
                $wallet->save();
            }

            $transaction = new Transaction();
            $transaction->amount = $amount;
            $transaction->reference_id = $userId->id;
            $transaction->credit = $newBalanceWallet;
            $transaction->bank_code = $bankCode;
            $transaction->type = 'topup';
            $transaction->save();

            DB::commit();

            return response()->json([
                "code" => 200,
                "message" => "Topup success",
            ],200);
        } catch(Exception $e) {
            DB::rollback();

            return response()->json([
                "code" => 500,
                "message" => "Topup failed in the process, please try again",
            ], 500);
        }
    }
}
