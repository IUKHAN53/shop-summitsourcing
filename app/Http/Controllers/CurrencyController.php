<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    public function setCurrency(Request $request)
    {
        $currency = $request->input('currency');
        session(['currency' => $currency]);

        return back();
    }
}
