<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;


class UserController extends Controller
{
    function setenovacode(Request $request)
    {
        $table = $request->json()->all();
        $user = User::where('uuid', $table['uuid'])->first();

        if ($user)
        {
            $user->enova_code = $table['code'];
            $user->save();
            return response()->json($request->json()->all());
        }
        else
        {
            return response(['message' => 'Brak użytkownika o podanym UUID.'], 403);
        }

    }
}
