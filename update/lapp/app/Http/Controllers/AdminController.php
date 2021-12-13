<?php

namespace App\Http\Controllers;

use App;

class AdminController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

}
