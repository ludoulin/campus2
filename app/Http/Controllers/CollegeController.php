<?php

namespace App\Http\Controllers;

use App\Models\College;
use Illuminate\Http\Request;

class CollegeController extends Controller
{
    public function show(College $college){
        
        return view('college.show', compact('college'));

    }
}
