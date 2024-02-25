<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class RegisterController extends Controller
{
    public function index()
    {
        return view('pages.authentication.register');
    }

    public function store(StoreRegisterRequest $request)
    {
        try {
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password)
            ]);

            auth()->attempt($request->only('email', 'password'));

            return redirect()->route('home')->withSuccess('Registration successful.');
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return redirect()->back()->withError('Something went wrong.');
        }
    }
}
