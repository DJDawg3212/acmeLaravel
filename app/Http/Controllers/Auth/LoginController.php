<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => ['required', 'email'],
            'password' => ['required', 'min:8', 'max:255'],
        ]);

        if (!User::where('email', $request->email)->first()) {
            return response()->json([
                'code' => '403',
                'message' => "Correo o contraseña incorrectos."
            ], 403);
        }

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'code' => '403',
                'message' => 'Correo o contraseña incorrectos.'
            ], 403);
        }

        $user = User::where('email', $request->email)->firstOrFail();
        $user = $user->makeHidden(['email_verified_at', 'created_at', 'updated_at', 'id', 'profile']);

        return response()->json([
            'code' => '200',
            'message' => 'Iniciaste sesion',
            'user' => $user,
        ], 200);
    }
}
