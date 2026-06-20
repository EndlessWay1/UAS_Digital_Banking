<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Beneficiary;

class BeneficiaryController extends Controller
{
    //to display beneficiary list

    public function index (Request $request)
    {
        $beneficiaries = Beneficiary::where(
            'user_id',
            $request->session()->get('id')
        )->get();
        return view ('beneficiaries.index', compact('beneficiaries'));
    }

    //to show create form

    public function create()
    {
        return view('beneficiaries.create');
    }

    //to store beneficiary

    public function store(Request $request)
    {
        $validated = $request->validate([
            'recipient_name' => 'required|string|max:225',
            'bank_name' => 'required|string|max:255',
            'account_number' => 'required|string|max:255',
            'alias' => 'nullable|string|max:255',
        ]);

        Beneficiary::create([
            'user_id' => $request->session()->get('id'),
            'recipient_name' => $validated['recipient_name'],
            'bank_name' => $validated['bank_name'],
            'account_number' => $validated['account_number'],
            'alias' => $validated['alias'],
        ]);

        return redirect()
        ->route('beneficiaries.index')
        ->with('success', 'Beneficiary Added Successfully!');
    }

    //to edit

    public function edit(Beneficiary $beneficiary)
    {
        return view('beneficiaries.edit', compact('beneficiary'));
    }

    public function update(Request $request, Beneficiary $beneficiary)
    {
        $request->validate([
            'recipient_name' => 'required',
            'account_number' => 'required',
            'bank_name' => 'required',
        ]);

        $beneficiary->update([
            'recipient_name' => $request->recipient_name,
            'account_number' => $request->account_number,
            'bank_name' => $request->bank_name,
            'alias' => $request->alias,
        ]);

        return redirect()->route('beneficiaries.index');
    }

    //to delete
    public function destroy(Beneficiary $beneficiary)
    {
        $beneficiary->delete();

        return redirect()->route('beneficiaries.index');
    }
}
