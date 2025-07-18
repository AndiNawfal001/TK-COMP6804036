<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public function register()
    {
        return view('register');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'string|max:255',
            'email' => 'email|unique:users,email',
            'password' => 'string|min:8|confirmed',
            'telephone' => 'nullable|string|max:20'
        ]);

        if ($validator->fails()) {
            return redirect()->route('register')
                ->withErrors($validator)
                ->withInput();
        }

        $data = $validator->validated();
        $data['group_id'] = 4;
        $data['password'] = Hash::make($request->password);
        $data['remember_token'] = Str::random(10);

        User::create($data);

        return redirect()->route('login')->with('success', 'Account Successfully created.');
    }

}
