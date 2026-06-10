<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SavingsPocketController extends Controller
{   
    public function index(Request $request)
    {
        $pockets = SavingsPocket::where(
            'user_id',
            $request->session()->get('id')
        )->get();

        return view('pocket.index', compact('pockets'));
    }

    //to create
    
    public function create()
    {
        return view('pocket.create');
    }

    //to store new savings pocket

    public function store(Request $request)
    {
        $request->validate([
            'purpose' => 'required',
            'target_amount' => 'required|numeric|min:1'
        ]);

        SavingsPocket::create([
            'user_id' => $request->session()->get('id'),
            'purpose' => $request->purpose,
            'target_amount' => $request->target_amount,
            'current_amount' => 0,
            'status' => 'In Progress',
        ]);

        return redirect()->route('pocket.index');
    }

    //to edit

    public function edit(SavingsPocket $pocket)
    {
        return view('pocket.edit', compact('pocket'));
    }

    //to update

    public function update(Request $request, SavingsPocket $pocket)
    {
        $pocket->update([
            'target_amount' => $request->target_amount,
        ]);

        return redirect()->route('pocket.index');
    }

    //to delete
    public function destroy(SavingsPocket $pocket)
    {
        $pocket->delete();

        return redirect()->route('pocket.index');
    }
}
