<x-mail::message>

Hello {{ $user->name }},

The following product(s) are expiring {{ config('constants.product.notification.send_expiry_for_notified_lots') ? 'in next 10 days' : 'after 10 days' }}. Please take necessary actions to avoid wastage.

{{ $lots->count() }} product(s) are expiring.

<x-mail::table>
    | Product Name | Quantity | Expiry Date |
    |--------------|----------|-------------|
    @foreach ($lots as $lot)
        | {{ $lot->product->name }} | {{ $lot->quantity }} | {{ $lot->expiry_date_formated }} |
    @endforeach
</x-mail::table>

<x-mail::button :url="route('login')">
    Login
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
