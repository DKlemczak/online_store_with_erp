<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    function index()
    {
        return view('user.index');
    }

    function userdata()
    {
        return view('user.userdata');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    function savedata(Request $request)
    {
        $user = User::where('id',Auth::User()->id)->first();
        $password = Auth::User()->password;
        if(\Hash::check($request->old_password, $password))
        {
            $user->name = $request->name;
            $user->surname = $request->surname;
            $user->NIP = $request->NIP;
            $user->city = $request->city;
            $user->post_code = $request->post_code;
            $user->street = $request->street;
            $user->building_number = $request->building_number;
            $user->email =  $request->email;
            $user->password =  Hash::make($request->password);
            $user->save();        
            return redirect()->back();
        }
        else
        {
            return redirect()->back()->with('Wiadomość','Błędne hasło');;
        }
    }
}
