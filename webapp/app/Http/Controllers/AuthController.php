<?php

namespace App\Http\Controllers;

use App\User;
use App\Post;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function home(){
        $posts = Post::with('images')->orderBy('created_at', 'DESC')->get();
        $tags = Tag::all();
        return view('home', [
            'tags' => $tags,
            'posts' => $posts
        ]);
    }

    public function showLoginPage(){
        return view('auth.login');
    }

    public function showSignUpPage(){
        return view('auth.signup');
    }

    public function signup(Request $request){
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'confirm' => ['required', 'string', 'same:password']
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('home');
    }

    public function login(Request $request){
        if (Auth::attempt([
            'email' => $request->email,
            'password' => $request->password 
        ])) {
            return redirect()->route('home');
        }
        return redirect()->route('login')->with('statusError', 'Email or password invalid');
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('home');
    }
}
