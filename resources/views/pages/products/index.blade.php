@extends('layouts.authenticated-layout')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 pt-5">
                <h1 class="text-center">Products</h1>
                <a href="{{ route('products.create') }}" class="btn btn-primary float-end">Create Product</a>
                @if ($products->isEmpty())
                    <h2 class="text-center mt-5 pt-5">No products found</h2>
                @else
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Quantity</th>
                                <th>Lots</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->lots_sum_quantity }}</td>
                                    <td>
                                        @foreach ($product->lots as $lot)
                                            {{ $lot->quantity }} ({{ $lot->expiry_date_formated }})<br>
                                        @endforeach
                                    </td>
                                    <td>
                                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning">Edit</a>
                                        <form method="POST" action="{{ route('products.destroy', $product->id) }}"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <input type="submit" class="btn btn-danger" value="Delete">
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center">
                        {{ $products->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
