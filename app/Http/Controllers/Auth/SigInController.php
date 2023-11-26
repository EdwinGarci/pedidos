<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\v1\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class SigInController extends BaseController
{
    //
    public function index()
    {
        // return view('auth.login_view');
        return view('auth.loginView');
    }

    public function signIn(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email', 'string'],
            'password' => ['required', 'string']
        ]);

        $remember = $request->filled('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            return redirect()
                ->intended('dashboard')
                ->with('status', 'Estas logeado');
        }

        throw ValidationException::withMessages([
            'email' => __('auth.failed')
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->intended('/');
    }
}

/* $credentials = $request->validate([
    'email' => ['required', 'email', 'string'],
    'password' => ['required', 'string']
]);

//dd( Hash::make('Developer2023$'));

if( Auth::attempt($credentials)) {
    //$request->authenticate();
    //$request->session()->regenerate();
    Auth::login($credentials);

    // return $this->sendResponse('', 'User login successfully.');
}else{
    //return $this->sendError('* Sus credenciales no coinciden con nuestros registros.', ['error'=>'Unauthorised']);
} */
