<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Http\Controllers\Controller;

use App\User;

class UserController extends Controller
{
    public function index(){
    	return view('index');
    }
	
	//用户登录
	public function login(){
		return view('user.login');
	}
	
	//用户注册
	public function create(){
		return view('user.create');
	}

	//执行用户注册方法
	public function store(Request $request){
		//执行数据的验证
		$this->validate($request,[
			'name'=>'required|max:50',
			'email'=>'required|email|unique:users|max:255',
			'password'=>'required|confirmed|min:6'
		],[
				'name.required'=>'姓名不能为空',
				'email.required'=>'邮箱不能为空',
				'email.unique:users'=>'此邮箱已被注册'
			]
		);

		//构建数据
		$data = [
			'name' => $request->name,
			'email' => $request->email,
			'password' => bcrypt($request->password)
		];

		//创建用户
		$user = User::create($data);

		//页面跳转
		return redirect()->route('user.show',[$user]);
	}


	//查看用户信息
	public function show($id){
		return view('user.center',['user'=>User::findOrFail($id)]);
	}


}