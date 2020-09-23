<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('banned');
    // }
    
    public function root()
    {
        return view('pages.root');
    }
}
