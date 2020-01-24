<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SessionController extends Controller
{
    public function loginUser(){
        return view('login');
    }
    public function postUser(Request $request){
        //ensure from email password in user table

        if(!auth()->attempt(request(['email','password']))){
            return redirect()->back()->withErrors([
               'message'=>'email or password not correct',
            ]);
        }

        //if exist redirect posts
        return redirect('/posts');
    }
    public function logout(){
        auth()->logout();
        return redirect('/posts');
    }
}
