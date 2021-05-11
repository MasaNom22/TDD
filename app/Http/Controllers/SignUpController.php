<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class SignUpController extends Controller
{
    public function index()
    {
        return view('signup');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'max:20'],
            'email' => ['required', 'email:filter'],
            'password' => ['required','min:4'],
        ]);
        User::create([
            'name' =>$request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
        ]);
        
        // auth()->login($user);

        // return redirect('mypage/blogs');
        
    }
}
