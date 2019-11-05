<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CustomController extends Controller
{
    public function customValidate(Request $request)
    {
    	$nrSongs = 5;
		return view('tracks', compact('nrSongs'));
    }
    public function showTracks($nrSongs = 5)
    {
		return view('tracks', compact('nrSongs'));
    }
}
