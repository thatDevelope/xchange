<?php

namespace App\Http\Controllers;

use App\Models\create_trades_table;
use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\OfferTable;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Trade;
use App\Models\CurrencyOrder;


class MessageController extends Controller
{
    public function inbox($receiverId = null)
    {
        $userId = Auth::id();
    
        // Get all active orders by the logged-in user
        $activeOrderIds = CurrencyOrder::where('user_id', $userId)
            ->where('status', 'active')
            ->pluck('id');
    
        // Check if the logged-in user has any active orders
        $loggedInUserHasActiveOrder = $activeOrderIds->isNotEmpty();
    
        if ($loggedInUserHasActiveOrder) {
            // Get users who accepted the logged-in user's active orders AND the offer was not canceled
            $conversations = User::whereIn('id', function ($query) use ($activeOrderIds) {
                $query->select('user_id')
                    ->from('offer_tables')
                    ->whereIn('order_id', $activeOrderIds)
                    ->where('status', '!=', 'canceled'); // 👈 Filter out canceled offers
            })->get();
        } else {
            // Show all users with active currency orders
            $conversations = User::whereHas('currencyOrders', function ($q) {
                $q->where('status', 'active');
            })->get();
        }
    
        // Load selected receiver and messages
        $receiver = $receiverId 
            ? User::findOrFail($receiverId) 
            : $conversations->first();
    
        $messages = [];
    
        if ($receiver) {
            $messages = Message::where(function ($query) use ($receiver, $userId) {
                $query->where('sender_id', $userId)
                      ->where('receiver_id', $receiver->id);
            })->orWhere(function ($query) use ($receiver, $userId) {
                $query->where('sender_id', $receiver->id)
                      ->where('receiver_id', $userId);
            })->orderBy('created_at')->get();
        }
    
        return view('userdashboard.message', compact('conversations', 'receiver', 'messages'));
    }
    
    public function sendMessage(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string',
        ]);

        Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
        ]);

        return back();
    }

    public function getMessages($receiverId)
{
    $userId = Auth::id();

    $messages = Message::where(function ($query) use ($receiverId, $userId) {
        $query->where('sender_id', $userId)->where('receiver_id', $receiverId);
    })->orWhere(function ($query) use ($receiverId, $userId) {
        $query->where('sender_id', $receiverId)->where('receiver_id', $userId);
    })->orderBy('created_at')->get();

    return response()->json($messages);
}


public function pairUser(Request $request)
{
    $userId = $request->user_id;  // Coming from the form
    $buyerId = Auth::id();         // Current logged-in user

    // (Here you decide what "pairing" means)
    // Maybe you create a trade, or you create a link between buyer and seller, etc.

    // Example (if you have OfferTable logic and want to fetch user's offer)
    $offer = OfferTable::where('user_id', $userId)->first();

    if (!$offer) {
        return back()->with('error', 'No offer found for this user.');
    }

    $trade = new create_trades_table();
    $trade->offer_id = $offer->id;
    $trade->buyer_id = $buyerId;
    $trade->seller_id = $userId;
    $trade->amount = $offer->amount;
    $trade->exchange_rate = $offer->exchange_rate;
    $trade->payment_status = 'pending';
    $trade->escrow_status = 'held';
    $trade->save();

    return back()->with('success', 'Trade created successfully!');
}

public function approveTrade($offer_id)
{
    $trade = create_trades_table::where('offer_id', $offer_id)->first();

    if (!$trade) {
        return back()->with('error', 'Trade not found.');
    }

    $trade->payment_status = 'completed';
    $trade->save();

    return back()->with('success', 'Payment status updated to completed.');
}


}
