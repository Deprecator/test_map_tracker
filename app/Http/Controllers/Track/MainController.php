<?php

namespace App\Http\Controllers\Track;

use App\Http\Controllers\Controller;

class MainController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function indexMain() {
        return view('main');
    }
}
