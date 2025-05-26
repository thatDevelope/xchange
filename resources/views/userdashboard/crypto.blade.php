@extends('userdashboard.index')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Connect Wallet</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item">Wallet</div>
            </div>
        </div>

        <div class="section-body">
            <h2 class="section-title">Crypto Wallet Connection</h2>
            <p class="section-lead">
                Connect your wallet to start using crypto-powered features on your account.
            </p>

            <div class="card mt-4">
                <div class="card-header">
                    <h4>Connect Your Crypto Wallet</h4>
                </div>
                <div class="card-body text-center">
                    <div id="wallet-info" class="mb-3 text-muted"></div>

                    <button id="connectWalletBtn" class="btn btn-primary">
                        <i class="fas fa-wallet mr-1"></i> Connect Wallet
                    </button>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection


<script src="https://cdn.jsdelivr.net/npm/ethers@5.7.2/dist/ethers.umd.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.getElementById('connectWalletBtn')?.addEventListener('click', async () => {
            if (typeof window.ethereum !== 'undefined') {
                try {
                    const provider = new ethers.providers.Web3Provider(window.ethereum);
                    await provider.send("eth_requestAccounts", []);
                    const signer = provider.getSigner();
                    const address = await signer.getAddress();

                    const message = "Link this wallet to your account.";
                    const signature = await signer.signMessage(message);

                    document.getElementById('wallet-info').innerText = `Connected Wallet Address: ${address}`;

                    // Send to backend
                    const response = await fetch("/verify-wallet", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({
                            address: address,
                            signature: signature,
                            message: message
                        })
                    });

                    const result = await response.json();
                    if (result.status) {
                        document.getElementById('wallet-info').innerText = result.status;
                    }

                } catch (err) {
                    console.error(err);
                    alert("Failed to connect wallet. Make sure MetaMask is installed and unlocked.");
                }
            } else {
                alert("MetaMask not detected. Please install MetaMask from https://metamask.io/");
            }
        });
    });
</script>
