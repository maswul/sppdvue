<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeC extends Controller
{
    //
    public function __construct()
    {
        $this->middleware(['auth','auth.lock']);
    }
    public function home()
    {
        return view('layouts.master');
    }

    public function locked()
    {
        session(['lock-expires-at' => now()->subMinutes(1)]);
        return redirect()->route('login.locked');
    }
}
