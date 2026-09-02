<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Todo;


class TodosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $validated = $request->validate([
            'todo' => ['required', 'string', 'max:255'],
        ])

        $todo = Todo::create($validated);

        return response()->json([
            'success' => 'true',
            'data' => $todo
        ], 201);

    }


    /**
     * Store a newly created resource in storage.
     */
    public function storeUser(Request $request)
    {
        
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ])
        

        $test = User::create($validated);

        return response()->json([
            'success' => 'true',
            'data' => $todo
        ], 201);

    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
