<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BackController extends Controller
{
    public function home()
    {
    	return view('back.layout');
    }
}
