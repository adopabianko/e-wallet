<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfilePhoneNumberRequest;
use App\Models\User;

class ProfileController extends Controller
{
    public function phoneNumber() {
        return view('profile.phone-number');
    }

    public function updatePhoneNumber(ProfilePhoneNumberRequest $request) {
        $user = User::find($request->id);
        $user->phone_number = $request->phone_number;
        $user->save();

        if ($user) {
            return redirect()->route('home');
        } else {
            abort(500);
        }
    }
}
