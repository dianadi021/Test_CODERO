<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Auth\LoginRequest;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    // public function create(): View
    public function create(): RedirectResponse
    {
        // return view('auth.login');
        return redirect('/');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        $qry = "SELECT usr.id as id_user, usr.username, usr.email, usr.is_active, usr.id_role, pdd.fullname FROM users usr JOIN penduduk pdd on pdd.id = usr.id_penduduk WHERE usr.username = ?";
        $user = DB::selectOne("$qry", [$request->username]);
        session(['user_login' => (array)$user]);

        $sessionId = session()->getId();
        Redis::setex("session:$sessionId", 3600, json_encode($user));

        // return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $sessionId = session()->getId();
        Redis::del("session:$sessionId");
        session()->forget('user_login');

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
