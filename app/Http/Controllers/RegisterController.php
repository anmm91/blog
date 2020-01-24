<?php

namespace App\Http\Controllers;

use App\Role;
use App\Setting;
use App\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function registerUser(){
        $stop_register=Setting::where('name','stop register')->value('value');
        return view('register',compact('stop_register'));
    }
    public function postUser(Request $request){
        //validate
        $rules=[
            'name'=>'required|max:15',
            'email'=>'required',
            'password'=>'required',
            'image'=>'required|mimes:jpeg,jpg,png',
        ];
        $message=[

        ];
        $this->validate($request,$rules,$message);
        if($request->hasFile('image')){
            $imageExtension=$request->file('image')->getClientOriginalExtension();
            $imageName=time().'user.'.$imageExtension;
            //upload to server
            $request->file('image')->storeAs('imageuser',$imageName);
        }else{
            $imageName='download254';
        }
        //create
        $user=new User();
        $user->name=$request->name;
        $user->email=$request->email;
        $user->password=bcrypt($request->password);
        $user->image=$imageName;
        $user->save();

        //login
        auth()->login($user);

        //determine role as default as user
        $user->roles()->attach(Role::where('name','user')->first());
        //redirct
        return redirect('/posts')->with('success','the name registered successfully');
    }
}
