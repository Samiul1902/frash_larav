<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;

class SettingsController extends Controller
{
    public function index()
    {
        $earnRate = Setting::getValue('loyalty_earn_rate', 10);
        $redeemValue = Setting::getValue('loyalty_redeem_value', 10);
        
        return view('admin.settings.index', compact('earnRate', 'redeemValue'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'loyalty_earn_rate' => 'required|integer|min:0',
            'loyalty_redeem_value' => 'required|numeric|min:0',
        ]);

        Setting::setValue('loyalty_earn_rate', $request->loyalty_earn_rate);
        Setting::setValue('loyalty_redeem_value', $request->loyalty_redeem_value);

        return back()->with('success', 'Settings updated successfully.');
    }
}
