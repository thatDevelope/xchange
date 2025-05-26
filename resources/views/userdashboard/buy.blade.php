<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pay with Paystack</title>
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="card shadow-lg" style="width: 100%; max-width: 400px;">
            <div class="card-body text-center">
                <h5 class="card-title mb-4">Make Payment</h5>
                <form method="POST" action="{{ route('pay') }}">
                    @csrf
                    <input type="text" name="email" value=""> {{-- required --}}
                    <input type="number" name="amount" value=""> {{-- in kobo = 5000 NGN --}}
                    <button type="submit" class="btn btn-success w-100">Pay with Paystack</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle JS (optional, for interactivity) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
