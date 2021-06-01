<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

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
}
