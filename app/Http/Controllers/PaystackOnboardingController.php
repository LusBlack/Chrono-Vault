<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaystackOnboardingController extends Controller
{
    public function index() {
        return view('onboarding');
    }
}
