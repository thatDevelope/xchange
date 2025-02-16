<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full"
                          type="password"
                          name="password"
                          required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                          type="password"
                          name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Gender -->
        <div class="mt-4">
            <x-input-label for="gender" :value="__('Gender')" />
            <select id="gender" name="gender" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                <option value="">{{ __('Select Gender') }}</option>
                <option value="male">{{ __('Male') }}</option>
                <option value="female">{{ __('Female') }}</option>
                <option value="other">{{ __('Other') }}</option>
            </select>
            <x-input-error :messages="$errors->get('gender')" class="mt-2" />
        </div>

        <!-- ID Type -->
        <div class="mt-4">
            <x-input-label for="id_type" :value="__('ID Type')" />
            <select id="id_type" name="id_type" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                <option value="">{{ __('Select ID Type') }}</option>
                <option value="passport">{{ __('Passport') }}</option>
                <option value="national_id">{{ __('National ID') }}</option>
                <option value="driver_license">{{ __('Driver’s License') }}</option>
            </select>
            <x-input-error :messages="$errors->get('id_type')" class="mt-2" />
        </div>

        <!-- ID Number -->
        <div class="mt-4">
            <x-input-label for="id_number" :value="__('ID Number')" />
            <x-text-input id="id_number" class="block mt-1 w-full" type="text" name="id_number" :value="old('id_number')" required />
            <x-input-error :messages="$errors->get('id_number')" class="mt-2" />
        </div>

        <label>Select Payment Methods:</label><br>

<input type="checkbox" name="payment_methods[]" value="Bank Transfer"> Bank Transfer <br>
<input type="checkbox" name="payment_methods[]" value="USDT"> USDT <br>
<input type="checkbox" name="payment_methods[]" value="PayPal"> PayPal <br>
<input type="checkbox" name="payment_methods[]" value="Cash"> Cash <br>

        <!-- KYC Status -->
        <div class="mt-4">
            <x-input-label for="kyc_status" :value="__('KYC Status')" />
            <select id="kyc_status" name="kyc_status" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                <option value="" disabled>{{ __('Select KYC Status') }}</option>
                <option value="pending" selected>{{ __('Pending') }}</option>
                <!-- <option value="verified">{{ __('Verified') }}</option>
                <option value="rejected">{{ __('Rejected') }}</option> -->
            </select>
            <x-input-error :messages="$errors->get('kyc_status')" class="mt-2" />
        </div>

        <div class="mt-4">
    <x-input-label for="country" :value="__('Country')" />

    <select id="country" name="country" class="block mt-1 w-full">
        <option value="">Select Country</option>
        @foreach($countryNames as $country)
            <option value="{{ $country }}">{{ $country }}</option>
        @endforeach
    </select>

    <x-input-error :messages="$errors->get('country')" class="mt-2" />
</div>




        <!-- KYC Document -->
        <div class="mt-4">
            <x-input-label for="kyc_document" :value="__('KYC Document')" />
            <x-text-input id="kyc_document" class="block mt-1 w-full" type="file" name="kyc_document" required />
            <x-input-error :messages="$errors->get('kyc_document')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
    <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
<!-- <script>
    $(document).ready(function () {
        $.get("{{ url('/countries') }}", function (data) {
            let countrySelect = $("#country");
            $.each(data, function (index, country) {
                countrySelect.append(`<option value="${country.code}">${country.name}</option>`);
            });
        });
    });
</script> -->
</x-guest-layout>
