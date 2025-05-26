@extends('userdashboard.index') <!-- Extend your dashboard layout -->

@section('content')
<div id="app">
   

      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>Profile</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="http://127.0.0.1:8000/userdash">Dashboard</a></div>
              <div class="breadcrumb-item">Profile</div>
            </div>
          </div>
          <div class="section-body">
            <h2 class="section-title">{{ $user->name }}</h2>
            <p class="section-lead">
            <p>
            <strong>Email:</strong>
            {{ $user->email }}
            </p>
            </p>

            <p class="section-lead">
           <p><strong>Phone number:</strong>{{ $user->phone_number }}</p>
            </p>
            @if ($user->wallet)
    <p><strong>Wallet ID:</strong> {{ $user->wallet->wallet_id }}</p>
    <p><strong>Type:</strong> {{ $user->wallet->type }}</p>
    <p><strong>Balance:</strong> ${{ number_format($user->wallet->balance, 2) }}</p>
@else
    <p>You do not have a wallet yet.</p>
@endif

            <div class="row mt-sm-4">
              <div class="col-12 col-md-12 col-lg-5">
                <div class="card profile-widget">
                  <div class="profile-widget-header">                     
                    <img alt="image" src="assets/img/avatar/avatar-1.png" class="rounded-circle profile-widget-picture">
                    <div class="profile-widget-items">
                      <div class="profile-widget-item">
                        <div class="profile-widget-item-label">Requests</div>
                        <div class="profile-widget-item-value">187</div>
                      </div>
                      <div class="profile-widget-item">
                        <div class="profile-widget-item-label">Accepted</div>
                        <div class="profile-widget-item-value">6,8K</div>
                      </div>
                      <div class="profile-widget-item">
                        <div class="profile-widget-item-label">Closed deal</div>
                        <div class="profile-widget-item-value">2,1K</div>
                      </div>
                    </div>
                  </div>
                  <!-- <div class="profile-widget-description">
                    <div class="profile-widget-name">Ujang Maman <div class="text-muted d-inline font-weight-normal"><div class="slash"></div> Web Developer</div></div>
                    Ujang maman is a superhero name in <b>Indonesia</b>, especially in my family. He is not a fictional character but an original hero in my family, a hero for his children and for his wife. So, I use the name as a user in this template. Not a tribute, I'm just bored with <b>'John Doe'</b>.
                  </div> -->
                  <div class="card-footer text-center">
                    <!-- <div class="font-weight-bold mb-2">Follow Ujang On</div> -->
                    <a href="#" class="btn btn-social-icon btn-facebook mr-1">
                      <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="btn btn-social-icon btn-twitter mr-1">
                      <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="btn btn-social-icon btn-github mr-1">
                      <i class="fab fa-github"></i>
                    </a>
                    <a href="#" class="btn btn-social-icon btn-instagram">
                      <i class="fab fa-instagram"></i>
                    </a>
                  </div>
                </div>
              </div>
              <div class="col-12 col-md-12 col-lg-7">
                <div class="card">
                @php
    $fullName = explode(' ', $user->name, 2);
    $firstName = $fullName[0];
    $lastName = $fullName[1] ?? ''; // If there's no last name, set it as empty
@endphp
                  <form action="{{ route('user.update', $user->id) }}" method="post" class="needs-validation" novalidate="">
                    @csrf
                    <div class="card-header">
                      <h4>Edit Profile</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">                               
                          <div class="form-group col-md-6 col-12">
                            <label>First Name</label>
                            <input type="text" class="form-control" value="{{ $firstName }}" >
                            <div class="invalid-feedback">
                              Please fill in the first name
                            </div>
                          </div>
                          <div class="form-group col-md-6 col-12">
                            <label>Last Name</label>
                            <input type="text" class="form-control" value="{{ $lastName }}">
                            <div class="invalid-feedback">
                              Please fill in the last name
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="form-group col-md-7 col-12">
                            <label>Email</label>
                            <input type="email" class="form-control" value="{{ $user->email }}" >
                            <div class="invalid-feedback">
                              Please fill in the email
                            </div>
                          </div>
                          <div class="form-group col-md-5 col-12">
                            <label>Phone</label>
                            <input type="text" name="phone_number" id="phone_number" class="form-control"
               value="{{ old('phone_number', $user->phone_number) }}">
                          </div>
                        </div>
                        <div class="row">
    <div class="form-group col-12">
        <label>New Password</label>
        <input type="password" name="password" class="form-control" placeholder="Enter new password">
    </div>
    <div class="form-group col-12 mt-3">
        <label>Confirm Password</label>
        <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm new password">
    </div>
</div>

<div class="row">
    <div class="form-group mb-0 col-12">
        <div class="custom-control custom-checkbox">
            <!-- Hidden input to ensure '0' is sent if unchecked -->
            <input type="hidden" name="subscribe" value="0">

            <!-- Checkbox input -->
            <input type="checkbox" name="subscribe" id="newsletter" class="custom-control-input"
                   value="1" {{ old('subscribe', $user->subscribe) ? 'checked' : '' }}>

            <label class="custom-control-label" for="newsletter">
                Subscribe to newsletter
            </label>

            <div class="text-muted form-text">
                You will get new information about products, offers, and promotions
            </div>
        </div>
    </div>
</div>

                    <div class="card-footer text-right">
                      <button class="btn btn-primary">Save Changes</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
@endsection
