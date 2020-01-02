<?php

namespace App\Http\Controllers;

use App\Clue;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // get a random clue
        $clueType = '';
        $clueName = '';
        $clues = Clue::where('used', '=', false)->get();
        if (count($clues) != 0) {
            $clue = $clues->random(1);
            if (!empty($clue)) {
                $clueName = $clue[0]->name;
                $clueType = $clue[0]->type->name;
            }
        }

        return view('home', ['clue' => $clueName, 'type' => $clueType]);
    }
}
