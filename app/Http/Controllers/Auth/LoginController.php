<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    // Hapus atau comment $redirectTo supaya tidak bentrok
    // protected $redirectTo = RouteServiceProvider::HOME;

    protected function authenticated(Request $request, $user)
    {
        switch ($user->id_role) {
            case 1: // Admin
                return redirect('/admin/dashboard');
            case 2: // Petugas Pendaftaran
                return redirect('/pendaftaran/dashboard');
            case 3: // Dokter
                return redirect('/dokter/dashboard');
            case 4: // Kasir
                return redirect('/kasir/dashboard');
            default:
                return redirect('/');
        }
    }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
