<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    public function __construct()
    {
        //中间件 权限判断
        //未登录的只能访问
        $this->middleware('guest',[
            'only'=>'create',
        ]);
        //不能错误访问
        $this->middleware('auth',[
            'except'=>['show','create','store']
        ]);

    }

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

    public function edit(User $user)
    {
        //有无权限
        $this->authorize('update',$user);
        return view('users.edit',compact('user'));
    }

    public function update(User $user,Request $request)
    {
        $this->validate($request,[
            'name'=>'required|max:50',
            'password'=>'nullable|confirmed|min:6'
        ]);
        //有无权限
        $this->authorize('update', $user);
        $data=[];
        $data['name']= $request->name;
        if($request->passowrd){
            $data['password']=bcrypt($request->password);
        }
        $user->update($data);
        session()->flash('success','个人资料更新成功');
        return redirect()->route('users.show',$user->id);
    }
}
