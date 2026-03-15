<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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
     * Where to redirect users after login depending on role.
     */
    protected function authenticated(\Illuminate\Http\Request $request, $user)
    {
        session()->flash('welcome', "Welcome back, {$user->name}!");

        if ($user->role === 'super_admin') {
            return redirect('/super-admin/dashboard');
        } elseif ($user->role === 'academic_master') {
            return redirect('/master/dashboard');
        } elseif ($user->role === 'academic_department') {
            return redirect('/department/dashboard');
        }

        return redirect('/teacher/dashboard');
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }
}
