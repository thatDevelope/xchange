@extends('userdashboard.index')

@section('content')
<style>
    .section-lead {
    font-size: 1.2rem;
    font-weight: 600;
    color: #fff;
    background: linear-gradient(135deg, #28a745, #218838);
    padding: 15px 20px;
    border-radius: 10px;
    text-align: center;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    transition: transform 0.3s ease-in-out;
}

.section-lead:hover {
    transform: scale(1.05);
}

.highlight {
    color: #ffd700;
    font-weight: bold;
    text-transform: uppercase;
    display: inline-block;
    padding: 3px 5px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 5px;
}

</style>
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Responses to My Exchange Requests</h1>
    </div>
    <p class="section-lead">
  Your exchange is secured. 
  <span class="highlight">However, please double-check all details before clicking the 'Approve' button.</span> Once payment is made to the person you're paired with, it cannot be reversed.
</p>
    <div class="section-body">
      @forelse($orders as $order)
        <div class="card mb-4">
          <div class="card-header">
            <strong>Request #{{ $order->id }}</strong> |
            {{ $order->currency }} → {{ $order->exchange_currency }} |
            {{ number_format($order->currency_amount, 2) }}
          </div>
          <div class="card-body">
            @if($order->offers->isEmpty())
              <p class="text-muted">No responses yet.</p>
            @else
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>User</th>
                    <th>Phone</th>
                    <th>Status</th>
                    <th>Responded At</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($order->offers as $offer)
                    <tr>
                      <td>{{ $offer->user->name }}</td>
                      <td>{{ $offer->user->phone }}</td>
                      <td>
                        @if($offer->status == 'accepted')
                          <span class="badge badge-success">Accepted</span>
                        @elseif($offer->status == 'rejected')
                          <span class="badge badge-danger">Rejected</span>
                        @else
                          <span class="badge badge-secondary">{{ ucfirst($offer->status) }}</span>
                        @endif
                      </td>
                      <td>{{ $offer->created_at->diffForHumans() }}</td>
                      <td>
                        <a href="{{ route('messages.inbox', $offer->user->id) }}" class="btn btn-sm btn-primary">
                          Chat
                        </a>

                        @if(session('success'))
                           <div class="alert alert-success">
                              {{ session('success') }}
                           </div>
                         @endif


                       @if(session('error'))
                         <div class="alert alert-danger">
                           {{ session('error') }}
                         </div>
                       @endif

  

                      
                          <form action="{{ route('trade.approve', $offer->id) }}" method="POST" style="display:inline;">
                            @csrf
                           <button type="submit" class="btn btn-sm btn-success">Approve</button>
                         </form>
                       
                         <!-- <span class="badge badge-success">Approved</span> -->
                        


                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            @endif
          </div>
        </div>
      @empty
        <div class="alert alert-info">You haven’t made any exchange requests yet.</div>
      @endforelse
    </div>
  </section>
</div>
@endsection
