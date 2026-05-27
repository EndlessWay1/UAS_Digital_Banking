<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cardless;

class CardlessTransactionController extends Controller
{
    public function deposit(Request $request)
    {
        $validateData = $request->validate([
            'amount' => 'requires|numeric',
            'cardless_id' => 'required|exists:cardless,id'
        ]);

        $cardless = Cardless::where('id', $request->input('cardless_id'))->firstOrFail();
        $cardless->amount += $request->input('amount');
        $cardless->save();

        return response()->json(['message' => 'Deposit sucessful']);
    }

    public function withdraw(Request $request)
    {
        
    }
}
