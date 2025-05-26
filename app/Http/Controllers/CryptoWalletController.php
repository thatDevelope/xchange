<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CryptoWallet;
use Illuminate\Support\Facades\Auth;

class CryptoWalletController extends Controller
{
    public function verify(Request $request)
    {
        $request->validate([
            'address' => 'required|string',
            'signature' => 'required|string',
            'message' => 'required|string',
        ]);

        // Basic validation, assuming trust in frontend signature (optional)
        $address = strtolower($request->address);

        // Store or update the wallet information for the user
        CryptoWallet::updateOrCreate(
            ['user_id' => Auth::id(), 'wallet_address' => $address],
            ['wallet_name' => 'MetaMask', 'network' => 'Ethereum']
        );

        return response()->json(['status' => 'Wallet linked successfully']);
    }


    public function showWalletConnectPage()
    {
        return view('userdashboard.crypto');
    }
}
