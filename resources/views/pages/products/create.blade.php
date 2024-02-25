@extends('layouts.authenticated-layout')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4 offset-md-4 pt-5">
                <h1 class="text-center">Create Product</h1>
                <form method="POST" action="{{ route('products.store') }}">
                    @include('pages.products.form')
                    <input type="submit" class="btn btn-primary" value="Create Product">
                </form>
            </div>
        </div>
    </div>
@endsection
