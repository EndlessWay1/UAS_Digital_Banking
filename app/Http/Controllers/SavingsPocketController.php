<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SavingsPocket;

class SavingsPocketController extends Controller
{   
    public function index(Request $request)
    {
        $pockets = SavingsPocket::where(
            'user_id',
            $request->session()->get('id')
        )->get();

        return view('pockets.index', compact('pockets'));
    }

    //to create
    
    public function create()
    {
        return view('pockets.create');
    }

    //to deposit money to the pocket
    public function depositForm(SavingsPocket $pocket)
    {
        return view('pockets.deposit', compact('pocket'));
    }

    public function deposit(Request $request, SavingsPocket $pocket)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1'
        ]);

        $pocket->current_amount += $request->amount;

        if ($pocket->current_amount >= $pocket->target_amount) {
            $pocket->status = 'Completed';
        }

        $pocket->save();

        return redirect()->route('pocket.index');
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
        return view('pockets.edit', compact('pocket'));
    }

    //to update

    public function update(Request $request, SavingsPocket $pocket)
    {
        $request->validate([
            'purpose' => 'required',
            'target_amount' => 'required|numeric|min:1',
        ]);

        $pocket->update([
            'purpose' => $request->purpose,
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
