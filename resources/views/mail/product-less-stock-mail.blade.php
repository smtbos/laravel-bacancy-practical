<x-mail::message>

Hello {{ $user->name }},

The following product(s) are less in stock. Please take necessary actions to avoid any disturbance.

{{ $products->count() }} product(s) has less stock

<x-mail::table>
    | Product Name | Current stock |
    |--------------|---------------|
    @foreach ($products as $product)
        | {{ $product->name }} | {{ $product->lots_sum_quantity }}|
    @endforeach
</x-mail::table>

<x-mail::button :url="route('login')">
    Login
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
