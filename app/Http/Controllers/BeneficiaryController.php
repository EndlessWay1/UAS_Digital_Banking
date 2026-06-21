<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Beneficiary;
use App\Models\Account;

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
            'account_number' => 'required|numeric',
            'alias' => 'nullable|string|max:255',
        ]);

        //to find the recipient account
        $account = Account::where(
            'account_number',
            $validated['account_number']
        )->first();

        if (!$account) {
            return back()->withErrors([
                'account_number' => 'Account number does not exist!'
            ])->withInput();
        }

        //to get the current user's account
        $currentUserAccount = Account::where(
            'user_id',
            $request->session()->get('id')
        )->first();

        //to validate that the recipient account is in the same bank
        if ($currentUserAccount->account_type_id != $account->account_type_id) {
                return back()->withErrors([
                    'account_number' => 'Only same=bank beneficiaries are allowed!'
                ])->withInput();
            }

        //to validate that the account number is not user's account
        if ($account->user_id == $request->session()->get('id')) {
            return back()->withErrors([
                'account_number' => 'You cannot add your own account to beneficiaries!'
            ])->withInput();
        }

        //to anticipate the duplication
        if (Beneficiary::where(
            'user_id',
            $request->session()->get('id')
        )->where(
            'account_number',
            $account->account_number
        )->exists()) {
            return back()->withErrors([
                'account_number' => 'Beneficiary already exists!'
            ]) ->withInput();
        }
        

        Beneficiary::create([
            'user_id' => $request->session()->get('id'),
            'recipient_name' => $account->user->name,
            'bank_name' => $account->accountType->name,
            'account_number' => $account->account_number,
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
