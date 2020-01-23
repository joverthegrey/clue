<?php

namespace App\Http\Controllers;

use App\Clue;
use App\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $user = Auth::user();
        $validTypesIds = [];

        if ($user->isAdmin()) {
            $validTypes = Type::all();
        } else {
            $validTypes = $user->role->types;
        }

        foreach ($validTypes as $type) {
            array_push($validTypesIds, $type->id);
        }

        // get a random clue
        $clueType = '';
        $clueName = '';
        $clues = Clue::where('used', '=', false)->whereIn('type_id', $validTypesIds)->get();
        if (count($clues) != 0) {
            $clue = $clues->random(1);
            if (!empty($clue)) {
                $clueName = $clue[0]->name;
                $clueType = $clue[0]->type->name;
            }
        }

        $activeClues = Clue::where(['used' => true])->get();

        return view('home', ['clue' => $clueName, 'type' => $clueType, 'active' => $activeClues, 'user' => $user]);
    }

    /**
     * Pick random hints to be used
     */
    public function pick()
    {
        // todo check for admin
        $this->middleware('pick');

        // clear used clues
        $clues = Clue::where(['used' => true])->get();
        foreach ($clues as $clue) {
            $clue->used = false;
            $clue->save();
        }

        // gather new clues
        $hintTypes = Type::all();
        foreach ($hintTypes as $hint_type) {
            $clues = Clue::where(['type_id' => $hint_type->id])->get();
            if (count($clues) != 0) {
                $clue = $clues->random(1);
                if (!empty($clue)) {
                    $clue = $clue[0];
                    $clue->used = true;
                    $clue->save();
                }
            }
        }

        return redirect(route('home'));
    }
}
