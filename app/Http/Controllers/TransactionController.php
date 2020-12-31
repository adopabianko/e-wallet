<?php

namespace App\Http\Controllers;

use App\Http\Requests\WithdrawRequest;
use App\Http\Requests\TransferRequest;
use App\Models\Wallet;
use App\Models\Transaction;
use DB;
use Auth;
use Session;
use App\Models\User;

class TransactionController extends Controller
{
    public function __construct() {
        $this->middleware(['auth', 'check_phone_number']);
    }

    public function withdraw() {
        return view('withdraw.create');
    }

    public function withdrawStore(WithdrawRequest $request) {
        $bankCode = $request->bank_code;
        $accountNumber = $request->account_number;
        $amount = $request->amount;
        $userId = Auth::user()->id;

        DB::beginTransaction();
        try {
            // Get Balance
            $balanceWallet = Wallet::select(DB::raw(' COALESCE(balance, 0) as balance'))
            ->where('user_id', $userId)
            ->first();

            if (!$balanceWallet) {
                Session::flash("alert-danger", "Your balance is not enough");

                return redirect()->route('transaction.withdraw');
            }

            $balance = $balanceWallet->balance;

            if ($amount > $balance) {
                Session::flash("alert-danger", "Your balance is not enough");

                return redirect()->route('transaction.withdraw');
            }

            $newBalanceWallet =  $balance - $amount;

            $wallet = Wallet::find($userId);
            $wallet->user_id = $userId;
            $wallet->balance = $newBalanceWallet;
            $wallet->save();

            $transaction = new Transaction();
            $transaction->amount = $amount;
            $transaction->reference_id = $userId;
            $transaction->debit = $newBalanceWallet;
            $transaction->bank_code = $bankCode;
            $transaction->type = 'withdraw';
            $transaction->save();

            DB::commit();

            Session::flash("alert-success", "Withdraw success");

            return redirect()->route('transaction.withdraw');
        } catch(Exception $e) {
            DB::rollback();

            Session::flash("alert-danger", "Withdraw failed in the process, please try again");

            return redirect()->route('transaction.withdraw');
        }
    }

    public function transfer() {
        return view('transfer.create');
    }

    public function transferStore(TransferRequest $request) {
        $phoneNumber = $request->phone_number;
        $amount = $request->amount;
        $description = $request->description;
        
        DB::beginTransaction();

        try {
            // Get Destination Account
            $desAccount = User::select('id')->where('phone_number', $phoneNumber)->first();

            if (!$desAccount) {
                Session::flash("alert-danger", "Phone Number is not found");

                return redirect()->route('transaction.transfer');
            }


            /************************
            ** Transferer Account **
            ************************/
            
            $transfererId = Auth::user()->id;

            // Get Balance Transferer
            $balanceWalletTrans = Wallet::select(DB::raw(' COALESCE(balance, 0) as balance'))
            ->where('user_id', $transfererId)
            ->first();

            if (!$balanceWalletTrans) {
                Session::flash("alert-danger", "Your balance is not enough");

                return redirect()->route('transaction.transfer');
            }

            $balance = $balanceWalletTrans->balance;

            if ($amount > $balance) {
                Session::flash("alert-danger", "Your balance is not enough");

                return redirect()->route('transaction.transfer');
            }

            // Transferer transaction history
            $newBalanceWalletTrans =  $balance - $amount;

            $wallet = Wallet::find($transfererId);
            $wallet->user_id = $transfererId;
            $wallet->balance = $newBalanceWalletTrans;
            $wallet->save();

            $transaction = new Transaction();
            $transaction->amount = $amount;
            $transaction->reference_id = $transfererId;
            $transaction->debit = $newBalanceWalletTrans;
            $transaction->type = 'transfer';
            $transaction->destination_id = $desAccount->id;
            $transaction->save();


            /************************
            ** Destination Account **
            ************************/

            // Get Balance Destination Account
            $balanceWalletDes = Wallet::select('id', DB::raw(' COALESCE(balance, 0) as balance'))
            ->where('user_id', $desAccount->id)
            ->first();

            // Destination account transaction history
            if (!$balanceWalletDes) {
                $newBalanceWalletDes = $amount;

                $wallet = new Wallet();
                $wallet->user_id = $desAccount->id;
                $wallet->balance = $newBalanceWalletDes;
                $wallet->save();
            } else {
                $newBalanceWalletDes = $amount + $balanceWalletDes->balance;
                
                $wallet = Wallet::find($desAccount->id);
                $wallet->user_id = $desAccount->id;
                $wallet->balance = $newBalanceWalletDes;
                $wallet->save();
            }

            $transaction = new Transaction();
            $transaction->amount = $amount;
            $transaction->reference_id = $desAccount->id;
            $transaction->credit = $newBalanceWalletDes;
            $transaction->type = 'transfer';
            $transaction->transferer_id = $transfererId;
            $transaction->save();

            DB::commit();

            Session::flash("alert-success", "Transfer success");

            return redirect()->route('transaction.transfer');
        } catch(Exception $e) {
            DB::rollback();

            Session::flash("alert-danger", "Transfer failed in the process, please try again");

            return redirect()->route('transaction.transfer');
        }
        
    }
}
