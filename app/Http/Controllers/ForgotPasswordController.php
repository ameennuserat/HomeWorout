<?php

namespace App\Http\Controllers;
// use App\Models\ResetCodePassword;
use Illuminate\Http\Request;
use Illuminate\support\Str;
// use Illuminate\Support\Facades\Mail;
// use App\Mail\SendCodeResetPassword;
//use App\Mail;
use App\Models\ResetCodePassword;
use App\Mail\SendCodeResetPassword;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\Auth\ForgotPasswordRequest;
//"rkicoiqdcuxwtgfi"
class ForgotPasswordController extends Controller
{
    public function __invoke(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email|exists:users',
        ]);

        // Delete all old code that user send before.
        ResetCodePassword::where('email', $request->email)->delete();

        // Generate random code
        $data['code'] = mt_rand(100000, 999999);

        // Create a new code
        $codeData = ResetCodePassword::create($data);

        // Send email to user
        //Mail::to($request->email)->send(new SendCodeResetPassword($codeData->code));
        Mail::to($request->email)->send(new SendCodeResetPassword($codeData->code));
        //return response(null, trans('passwords.sent'), 200);
        return response(['message' => trans('code.sent')], 200);
    }
}
