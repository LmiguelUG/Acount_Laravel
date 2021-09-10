<?php

namespace App\Http\Controllers;
Use App\Models\Account;

use Illuminate\Http\Request;

class BalanceController extends Controller
{
    public function show(Request $request) {

        $account_id = $request->input('account_id');
        $account = Account::findOrFail($account_id);

  
        return $account->balance;
    }
}
