<?php

namespace App\Http\Controllers;

use App\Http\Middleware\RedirectIfUserHasNotEnabledPaystack;
use Illuminate\Http\Request;

class DashBoardController extends Controller
{

    public function __construct() {
        $this->middleware (['auth', 'verified', RedirectIfUserHasNotEnabledPaystack::class]);
    }

    public function __invoke() {
        return view('dashboard');
    }
}
