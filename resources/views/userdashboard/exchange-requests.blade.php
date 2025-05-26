@extends('userdashboard.index')

@section('content')
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Currency Exchange Offers</h1>
    </div>

    <div class="section-body">
      {{-- Flash Messages --}}
      @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
      @endif
      @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
      @endif

      @if($orders->isEmpty())
        <div class="alert alert-info">
          No exchange requests available right now.
        </div>
      @endif


      @if(session('reject_success'))
  <div class="alert alert-warning">{{ session('reject_success') }}</div>
@endif

@if(session('reject_error'))
  <div class="alert alert-danger">{{ session('reject_error') }}</div>
@endif

      <div class="row">
        @foreach($orders as $order)
          <div class="col-12 col-md-6 col-lg-4">
            <div class="card mb-4">
              <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-2">
                  <h5 class="card-title mb-0">{{ $order->user->name }}</h5>
                  <small class="text-muted">{{ $order->user->phone }}</small>
                </div>
                <ul class="list-unstyled mb-3">
                  <li><strong>Currency:</strong> {{ $order->currency }}</li>
                  <li><strong>Exchange To:</strong> {{ $order->exchange_currency }}</li>
                  <li><strong>Amount:</strong> {{ number_format($order->currency_amount, 2) }}</li>
                  <li><strong>Exchange To:</strong> {{ $order->location }}</li>
                </ul>
                @php
    $userHasAccepted = \App\Models\OfferTable::where('order_id', $order->id)
                        ->where('user_id', Auth::id())
                        ->where('status', 'open')
                        ->exists();
@endphp

@if($order->status === 'active')

    {{-- Accept Button (only show if THIS user has NOT accepted it yet) --}}
    @if(!$userHasAccepted)
        <form action="{{ route('exchange.accept', $order->id) }}" method="POST" class="mb-2">
            @csrf
            <button type="submit" class="btn btn-success btn-block">
                Accept Request
            </button>
        </form>
    @else
        <button class="btn btn-secondary btn-block" disabled>
            You already accepted this request
        </button>
    @endif

    {{-- Reject Button (only show if THIS user already accepted it) --}}
    @php
        $userOffer = \App\Models\OfferTable::where('order_id', $order->id)
                        ->where('user_id', Auth::id())
                        ->where('status', 'open')
                        ->first();
    @endphp

    @if($userOffer)
        <form action="{{ route('exchange.reject', $userOffer->id) }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-warning btn-block">
                Reject (Cancel Your Offer)
            </button>
        </form>
    @endif

@elseif($order->status === 'canceled')
    <div class="alert alert-danger text-center">Request Canceled</div>
@endif

              </div>
            </div>
          </div>
        @endforeach
      </div>
    </div>
    <script>
  function disableAccept(form) {
    const button = form.querySelector('button[type="submit"]');
    button.disabled = true;
    button.style.opacity = '0.5'; // make it look blurred
    button.innerText = 'Accepted...';
  }

  function enableAccept(orderId) {
    const acceptBtn = document.getElementById(`acceptBtn-${orderId}`);
    if (acceptBtn) {
      acceptBtn.disabled = false;
      acceptBtn.style.opacity = '1';
      acceptBtn.innerText = 'Accept Request';
    }
  }
</script>
  </section>
</div>


@endsection
