<?php

namespace App\Http\Controllers;
use App\Models\ResetCodePassword;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Notifications\SignupActivate;
use Illuminate\support\Str;
use bcrybt;
class ResetPasswordController extends Controller
{
    public function __invoke(Request $request)
    {
        $input=$request->validate([
            'code' => 'required|string|exists:reset_code_passwords',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // find the code
        $passwordReset = ResetCodePassword::firstWhere('code', $request->code);

        // check if it does not expired: the time is one hour
        if ($passwordReset->created_at > now()->addHour()) {
            $passwordReset->delete();
            return response(['message' => trans('passwords.code_is_expire')], 422);
        }


        // find user's email
        $user = User::firstWhere('email',$passwordReset->email);

        $input['password']=bcrypt($input['password']);
       // update user password
        $user->update([
            'password'=>$input['password']
        ]);
        //$user->update($request->only('password'));

        // delete current code
        $passwordReset->delete();

        return response(['message' =>'password has been successfully reset'], 200);
    }
}
