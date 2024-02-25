@extends('layouts.authenticated-layout')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 pt-5">
                <h1 class="text-center">Dashboard</h1>
            </div>
            <div class="col-6 text-center">
                <h4>
                    Product lots expiring
                    @if (config('constants.product.notification.send_expiry_for_notified_lots'))
                        in next 10 days
                    @else
                        after 10 days
                    @endif
                </h4>
                @if ($lotsExpiring->isEmpty())
                    <h5 class="mt-5 pt-5">
                        No lots expiring
                        @if (config('constants.product.notification.send_expiry_for_notified_lots'))
                            in next 10 days
                        @else
                            after 10 days
                        @endif
                    </h5>
                @else
                    <table class="table text-start">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Expiry Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($lotsExpiring as $lot)
                                <tr>
                                    <td>{{ $lot->product->name }}</td>
                                    <td>{{ $lot->quantity }}</td>
                                    <td>{{ $lot->expiry_date_formated }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <a class="btn btn-primary" href="{{ route('products.mail.expiry') }}">Send Email</a>
                @endif
            </div>
            <div class="col-6 text-center">
                <h4>Products less in inventory</h4>
                @if ($productsLessStock->isEmpty())
                    <h5 class="mt-5 pt-5">No products less in inventory</h5>
                @else
                    <table class="table text-start">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Current stock</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($productsLessStock as $product)
                                <tr>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->lots_sum_quantity }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <a class="btn btn-primary" href="{{ route('products.mail.less-stock') }}">Send Email</a>
                @endif
            </div>
        </div>
    </div>
@endsection
