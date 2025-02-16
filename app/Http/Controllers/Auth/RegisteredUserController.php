<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;
use Rinvex\Country\CountryLoader;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $countries = CountryLoader::countries();

        // Ensure it's properly converted to an array
        if (!is_array($countries)) {
            $countries = json_decode($countries, true);
        }
    
        // Extract country names properly
        $countryNames = collect($countries)->map(function ($country) {
            return $country['name'] ?? 'Unknown';
        })->toArray();
    
        return view('auth.register', compact('countryNames'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        try {
            // Validate the input fields
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
                'gender' => ['required', 'string', 'in:male,female,other'], // Gender validation
                'id_type' => ['required', 'string', 'max:255'], // ID type validation
                'id_number' => ['required', 'string', 'max:255'], // ID number validation
                'payment_methods' => ['required', 'array', 'min:1'], // Ensure at least one payment method is selected
                'payment_methods.*' => ['string', 'in:Bank Transfer,USDT,PayPal,Cash'], // Validate each method
                'kyc_document' => ['required', 'file', 'mimes:jpg,png,pdf', 'max:2048'], // KYC document validation
                'country' => ['required', 'string', 'max:255'], // Validate country
            ]);
    
            // Handle file upload for KYC document
            $kycDocumentPath = null;
            if ($request->hasFile('kyc_document')) {
                $kycDocumentPath = $request->file('kyc_document')->store('kyc_documents', 'public');
            }
    
            // Create the user
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'gender' => $request->gender,
                'id_type' => $request->id_type,
                'id_number' => $request->id_number,
                'payment_methods' => json_encode($request->payment_methods), // Store payment methods as JSON
                'kyc_status' => 'pending', // Default KYC status
                'kyc_document' => $kycDocumentPath,
                'country' => $request->country, // Store country
                
            ]);
    
            // Fire the registered event
            event(new Registered($user));
    
            // Log the user in
            Auth::login($user);
    
            // Log success message
            Log::info('User successfully registered', ['user_id' => $user->id]);
    
            return redirect(route('dashboard', absolute: false));
        } catch (\Exception $e) {
            // Log the error message
            Log::error('Error during user registration', ['error' => $e->getMessage()]);
    
            return back()->withErrors(['message' => 'An error occurred during registration. Please try again.']);
        }
    }
}
