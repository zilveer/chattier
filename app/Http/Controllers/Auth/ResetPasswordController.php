<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    public function __construct()
    {
        $this->middleware('guest:api');
    }

    protected function rules()
    {
        return [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ];
    }

    protected function resetPassword($user, $password)
    {
        $user->password = $password;

        $user->save();
    }

    protected function guard()
    {
        return auth()->guard('api');
    }

    protected function sendResetResponse($response)
    {
        $token = $this->guard()->attempt(request()->only(['email', 'password']));
        $user = $this->guard()->user();
        $flash = trans($response);

        return response()->json(compact('token', 'user', 'flash'));
    }

    protected function sendResetFailedResponse(Request $request, $response)
    {
        return response()->json([
            'errors' => [
                'email' => [trans($response)],
            ],
        ], 422);
    }
}
