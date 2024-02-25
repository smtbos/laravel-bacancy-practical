@extends('layouts.guest-layout')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4 offset-md-4 pt-5">
                <h1 class="text-center">Login</h1>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="email">E-Mail Address</label>
                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}">
                        @error('email')
                            <div class="invalid-feedback d-block">
                                {{ $errors->first('email') }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label for="password">Password</label>
                        <input id="password" type="password" class="form-control" name="password">
                        @error('password')
                            <div class="invalid-feedback d-block">
                                {{ $errors->first('password') }}
                            </div>
                        @enderror
                    </div>
                    <input type="submit" class="btn btn-primary" value="Login">
                </form>
            </div>
        </div>
    </div>
@endsection
