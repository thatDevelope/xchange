<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CurrencyOrder;
use App\Models\OfferTable;
use App\Models\Trade;
use Illuminate\Support\Facades\Auth;
use Rinvex\Country\CountryLoader;
use App\Models\User;
use App\Notifications\NewOrderNotification;
use Illuminate\Support\Facades\Notification;

class CurrencyOrderController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'currency'          => 'nullable|string',
            'exchange_currency' => 'nullable|string',
            'currency_amount'   => 'nullable|numeric',
            'exchange_rate'     => 'nullable|numeric',
            'exchange_amount'   => 'nullable|numeric',
            'total_price'       => 'nullable|numeric',
            'location'          => 'nullable|string',
        ]);

        $order = CurrencyOrder::create([
            'user_id'           => Auth::id(), // Automatically assigns logged-in user
            'currency'          => $request->currency,
            'exchange_currency' => $request->exchange_currency,
            'currency_amount'   => $request->currency_amount,
            'exchange_rate'     => $request->exchange_rate,
            'exchange_amount'   => $request->exchange_amount,
            'total_price'       => $request->exchange_amount,
            'status'            => 'pending', // default status
            'location'         =>  $request->location,
        ]);

       $usersToNotify = User::where('id', '!=', Auth::id())->get();
       Notification::send($usersToNotify, new NewOrderNotification($order));


        return redirect()->back()->with('success', 'Currency exchange order submitted successfully! You will be notified when its approved');
    }


    public function showExchangeRequests()
{
    $userId = Auth::id();

    $orders = CurrencyOrder::where('user_id', '!=', $userId)
        ->where('status', 'active') // only active
        ->latest()
        ->with('user')
        ->get();

    return view('userdashboard.exchange-requests', compact('orders'));
}

public function accept($id)
{
    $currencyOrder = CurrencyOrder::where('status', 'active')->findOrFail($id);

    // Prevent user from accepting their own offer
    if ($currencyOrder->user_id == Auth::id()) {
        return redirect()->back()->with('error', 'You cannot accept your own offer.');
    }

    // Optionally mark original offer as closed
    // $currencyOrder->update(['status' => 'closed']);

    

    // Create new offer (maybe reversed or linked to original)
    OfferTable::create([
        'user_id'        => Auth::id(), // person accepting it becomes the new offer creator
        'order_id'       => $currencyOrder->id, // 👈 This is the magic link
        'currency_from'  => $currencyOrder->currency, // what the buyer is offering     // reversed?
        'currency_to'    => $currencyOrder->exchange_currency,   // reversed?
        'amount'         => $currencyOrder->exchange_amount,
        'exchange_rate'  => $currencyOrder->exchange_rate,
        'payment_method' => $currencyOrder->payment_method,
        'status'         => 'open',
    ]);

  
    return redirect()->back()->with('success', 'Offer accepted and new offer created.');
}


public function reject($id)
{
    $offer = OfferTable::where('id', $id)->where('status', 'open')->firstOrFail();// Assuming 'open' is the default

    if ($offer->user_id == Auth::id()) {
        return redirect()->back()->with('reject_error', 'You cannot reject your own offer.');
    }

    $offer->update(['status' => 'canceled']);

    

    return redirect()->back()->with('reject_success', 'Offer rejected.');
}


public function myRequestsResponses()
{
    $userId = Auth::id();

    // Get orders placed by this user
    $orders = CurrencyOrder::where('user_id', $userId)
        ->with(['offers.user']) // eager load accepted users
        ->get();

    return view('userdashboard.my-request-accepts', compact('orders'));
}

public function rejectByOrder($id)
{
    $offer = OfferTable::findOrFail($id); // Only fail if not found

    // Only the user who accepted it can cancel it
    if ($offer->user_id !== Auth::id()) {
        return redirect()->back()->with('reject_error', 'You are not allowed to reject this offer.');
    }

    // Prevent double rejection
    if ($offer->status !== 'open') {
        return redirect()->back()->with('reject_error', 'This offer is no longer active.');
    }

    // Update status
    $offer->update(['status' => 'canceled']);

    return redirect()->back()->with('reject_success', 'Offer rejected successfully.');
}




}
