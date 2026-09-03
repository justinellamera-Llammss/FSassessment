<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    //

    public function store(Request $request)
    {        
        // $validated = $request->validate([
        //     'name' => ['required', 'string', 'max:255'],
        // ]);

        $userIdentity = User::create([
            "name" => $request->name
        ]);

        return response()->json([
            'success' => 'true',
            'data' => $userIdentity
        ], 201);
    }
}
