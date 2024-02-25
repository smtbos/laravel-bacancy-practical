@extends('layouts.authenticated-layout')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4 offset-md-4 pt-5">
                <h1 class="text-center">Edit Product</h1>
                <form method="POST" action="{{ route('products.update', ['product' => $product]) }}">
                    @csrf
                    @method('PUT')
                    @include('pages.products.form')
                    <input type="submit" class="btn btn-primary" value="Update Product">
                </form>
            </div>
        </div>
    </div>
@endsection
