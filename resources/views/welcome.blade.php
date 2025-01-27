<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

    </head>
    <body class="font-sans antialiased dark:bg-black dark:text-white/50">
        <?php
        // more details https://paystack.com/docs/payments/multi-split-payments/#dynamic-splits

        $split = [
        "type" => "percentage",
        "currency" => "ZAR",
        "subaccounts" => [
            [ "subaccount" => "ACCT_li4p6kte2dolodo", "share" => 10 ],
            [ "subaccount" => "ACCT_li4p6kte2dolodo", "share" => 30 ],
        ],
        "bearer_type" => "all",
        "main_account_share" => 70
        ];
        ?>
        @if(session('message'))
            @php
                $alertType = match(session('message.type')) {
                    'error' => 'danger',
                    'success' => 'success',
                    'warning' => 'warning',
                    default => 'info',
                };
            @endphp

            <div class="alert alert-{{ $alertType }}">
                {{ session('message.msg') }}
            </div>
        @endif
        <form method="POST" action="{{ route('pay') }}">
            @csrf
            <input type="hidden" name="email" value="customer@example.com">
            <input type="hidden" name="amount" value="1000"> <!-- Amount in Naira -->
            <input type="hidden" name="orderID" value="12345">
            <input type="hidden" name="quantity" value="2">
            <button type="submit" class="btn btn-primary">Pay Now</button>
        </form>
        
        
    </body>
</html>
