<div class="col-md-4">
    <div class="ewallet-card filled"
         onclick="openEditModal({{ $wallet->id }}, '{{ $wallet->name }}', '{{ $wallet->phone }}')">

        <div class="wallet-logo">
            {{ strtoupper(substr($wallet->name, 0, 2)) }}
        </div>

        <div class="wallet-name">{{ $wallet->name }}</div>
        <div class="wallet-phone">{{ $wallet->phone }}</div>

    </div>
</div>