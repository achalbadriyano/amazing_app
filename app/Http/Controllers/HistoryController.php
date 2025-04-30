<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\History;

class HistoryController extends Controller
{
    public function index()
    {
        $active = 'motor';
        $histories = History::all();
        return view('motor.index', compact('histories', 'active'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required|max:255',
            'date' => 'required|date',
            'time' => 'required'
        ]);

        // Simpan data ke database
        History::create([
            'title' => $request->title,
            'description' => $request->description,
            'date' => $request->date,
            'time' => $request->time
        ]);

        return redirect('/motor')->with('success', 'History was created!');
    }
}
