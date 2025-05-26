<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use Paystack;
use Auth;
use Unicodeveloper\Paystack\Facades\Paystack;
use Illuminate\Support\Facades\Http;

class PaymentController extends Controller
{
    public function redirectToGateway(Request $request)
    {
        $email = $request->input('email');
        $amount = $request->input('amount') * 100; // Convert ₦ to Kobo
    
        $response = Http::withToken(env('PAYSTACK_SECRET_KEY'))
            ->post('https://api.paystack.co/transaction/initialize', [
                'email' => $email,
                'amount' => $amount
            ]);
    
        if ($response->successful()) {
            $authUrl = $response->json()['data']['authorization_url'];
            return redirect($authUrl);
        }
    
        return back()->with('error', 'Unable to initiate payment. Try again.');
    }
    public function display(){
        return view('userdashboard.buy');
    }
}
