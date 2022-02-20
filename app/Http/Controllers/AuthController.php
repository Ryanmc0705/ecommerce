<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function store(UserRequest $request){
        try{
            \DB::beginTransaction();
                $company = new Company();
                $company->name = $request->company_name;
                $company->save();
                $user = new User();
                $user->firstname = $request->firstname;
                $user->lastname = $request->lastname;
                $user->contact_number = $request->contact_number;
                $user->address = $request->address;
                $user->type = $request->type;
                $user->email = $request->email;
                $user->password = bcrypt($request->password);

                $company->User()->save($user);

            \DB::commit();
            return response([
                "message" => "success"
            ]);
        }catch(\Throwable $e){
            \DB::rollback();
            return response([
                "error" => $e->getMessage()
            ]);
        }
    }
    public function login(Request $request)
    {
        $user = User::where("email",$request->email)->first(["id","firstname","lastname","email","password","company_id"]);
        if($user && Hash::check($request->password,$user->password)){
            $jwt = $user->createToken($user->email)->plainTextToken;
            $cookie = cookie("jwt",$jwt,60*24);
            return response([
                "message" => "Login Success",
                "user" => $user,
               
            ])->withCookie($cookie);
        }else{
            return response([
                "message"=>"Bad Login"
            ],401);
        }
    }
    public function logout()
    {
        $cookie = Cookie::forget("jwt");
        return  response([
            "message" => "logout success"
        ])->withCookie($cookie);
    }
}
