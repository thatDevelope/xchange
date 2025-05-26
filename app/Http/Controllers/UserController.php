<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\RedirectResponse;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Alcohol\ISO4217;
use Illuminate\Support\Facades\Http;
use App\Models\Wallet;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function user(){
        $user = Auth::user();

    // Check if the user already has a wallet
    $wallet = Wallet::where('user_id', $user->id)->first();

    // If the user doesn't have a wallet, create one
    if (!$wallet) {
        Wallet::create([
            'user_id' => $user->id,
            'wallet_id' => Str::uuid(), // Generate UUID for the wallet
            'type' => 'main', // Default wallet type
            'balance' => 0, // Start with 0 balance
        ]);
    }
        return view('user.userdashboard');
    }


    public function dash(){
        $user = Auth::user();

        // Check if the user already has a wallet
        $wallet = Wallet::where('user_id', $user->id)->first();
    
        // If the user doesn't have a wallet, create one
        if (!$wallet) {
            Wallet::create([
                'user_id' => $user->id,
                'wallet_id' => Str::uuid(), // Generate UUID for the wallet
                'type' => 'main', // Default wallet type
                'balance' => 0, // Start with 0 balance
            ]);
        }
           
        return view('userdashboard.main');
    }

    public function currency(){
        $iso4217 = new ISO4217();
        $currencies = $iso4217->getAll();
        return view('userdashboard.currency',compact('currencies'));
    }



    public function update(Request $request, $id): JsonResponse
    {
        try {
            // Validate the input fields
            $request->validate([
                'name' => ['sometimes', 'string', 'max:255'],
                'email' => ['sometimes', 'string', 'lowercase', 'email', 'max:255', Rule::unique('users')->ignore($id)],
               'password' => ['nullable', 'sometimes', 'confirmed', Password::defaults()],
                'gender' => ['sometimes', 'string', 'in:male,female,other'],
                'id_type' => ['sometimes', 'string', 'max:255'],
                'id_number' => ['sometimes', 'string', 'max:255'],
                'phone_number' => ['sometimes', 'string', 'max:15'], // New validation rule
                'payment_methods' => ['sometimes', 'array', 'min:1'],
                'payment_methods.*' => ['string', 'in:Bank Transfer,USDT,PayPal,Cash'],
                'kyc_document' => ['sometimes', 'file', 'mimes:jpg,png,pdf', 'max:2048'],
                'country' => ['sometimes', 'string', 'max:255'],
                'subscribe' => ['nullable', 'boolean'], // Allow nullable subscription
            ]);


            if ($request->filled('password')) {
                if (!$request->has('password_confirmation')) {
                    return response()->json(['message' => 'Please confirm your new password.'], 422);
                }
            
                $request->validate([
                    'password' => ['required', 'confirmed', Password::defaults()],
                ]);
            
                // Hash new password
                $password = Hash::make($request->password);
            } else {
                $password = null; // No password change
            }
            
    
            // Find the user
            $user = User::findOrFail($id);
    
            // Update user fields
            $user->fill($request->only(['name', 'email', 'gender', 'id_type', 'id_number', 'country', 'phone_number','subscribe']));
            if ($request->has('phone_number')) {
                $user->phone_number = $request->phone_number;
            }

            if ($request->has('subscribe')) {
                $user->subscribe = $request->subscribe;
            }
    
            // Update payment methods if provided
            if ($request->has('payment_methods')) {
                $user->payment_methods = json_encode($request->payment_methods);
            }
    
            // Handle file upload for KYC document
            if ($request->hasFile('kyc_document')) {
                if ($user->kyc_document) {
                    Storage::disk('public')->delete($user->kyc_document); // Delete old file
                }
                $kycDocumentPath = $request->file('kyc_document')->store('kyc_documents', 'public');
                $user->kyc_document = $kycDocumentPath;
                $user->kyc_status = 'pending'; // Reset KYC status on document update
            }
    
            // Hash new password if provided
            // if ($request->filled('password')) {
            //     $request->validate([
            //         'password' => ['confirmed', Password::defaults()],
            //     ]);
            // }
    
            $user->save();
    
            // Log success message
            Log::info('User successfully updated', ['user_id' => $user->id]);
    
            return response()->json(['message' => 'User successfully updated', 'user' => $user], 200);
        } catch (ModelNotFoundException $e) {
            Log::error('User not found', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'User not found'], 404);
        } catch (\Exception $e) {
            Log::error('Error during user update', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'An error occurred during update. Please try again.'], 500);
        }
    }

//     public function getRate()
//     {
//         $apiKey = '34czmfT3DfBVeXrlHbLi9cWy96hrtOwp';

//         // API URL
//         $url = "https://api.apilayer.com/exchangerates_data/latest?symbols=NGN&base=USD&apikey={$apiKey}";

//         // Make the API request
//         $response = Http::get($url);
//         $data = $response->json();

//         // Check if the request was successful
//         if ($data['success'] ?? false) {
//             return response()->json([
//                 'USD to NGN' => $data['rates']['NGN']
//             ]);
//         } else {
//             return response()->json([
//                 'error' => 'Exchange rate not available',
//                 'api_response' => $data // Debugging: Show full API response if error occurs
//             ]);
//         }
    
// }


public function getExchangeRate($from = 'USD', $to = 'NGN')
{
    $apiKey = env('EXCHANGE_API_KEY');

    $url = "https://api.apilayer.com/exchangerates_data/latest?symbols={$to}&base={$from}&apikey={$apiKey}";

    try {
        $response = Http::get($url);

        if (!$response->successful()) {
            Log::error('Exchange API failed', ['response' => $response->body()]);
            return response()->json(['error' => 'Error fetching rate.']);
        }

        $data = $response->json();

        if ($data['success'] ?? false) {
            return response()->json([
                'exchange_rate' => $data['rates'][$to] ?? 'Rate not found', // 👈 renamed key
                'from' => $from,
                'to' => $to,
                'date' => $data['date'],
            ]);
        } else {
            return response()->json([
                'error' => $data['error']['info'] ?? 'Something went wrong'
            ]);
        }
    } catch (\Exception $e) {
        Log::error('Exchange API exception', ['message' => $e->getMessage()]);
        return response()->json(['error' => 'Exception: ' . $e->getMessage()]);
    }
}


}