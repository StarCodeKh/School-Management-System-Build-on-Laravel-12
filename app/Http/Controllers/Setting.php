<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Setting extends Controller
{
    // index page setting
    public function index()
    {
        return view('setting.settings');
    }
}
