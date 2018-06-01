<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function create()
    {
        return view('users.create');
    }
    //User 为 Eloquent模型  $user 为路由中的值
    public function show(User $user)
    {
        return view('users.show',compact('user'));
    }
    //接受数据
    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|max:50',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|confirmed|min:6'
        ]);

        $user =User::create([
            'name'=>$request->name,
            'password' => bcrypt($request->password),
            'email' => $request->email,
        ]);
        //注册后自动登录
        Auth::login($user);
        session()->flash('success','欢迎，您将开启一段新的旅程！');
        return redirect()->route('users.show',[$user]);
    }
}
