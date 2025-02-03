<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    public function signout(Request $request)
    {
        Auth::logout(); // Logout user
        Session::flush(); // Hapus semua session
        $request->session()->invalidate(); // Invalidasi session
        $request->session()->regenerateToken(); // Regenerasi token CSRF untuk keamanan
        
        return redirect()->route('login'); // Redirect ke halaman login
    }
}
