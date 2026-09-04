<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;


class TodosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Add pagination later
        $todo = Todo::where('user_id', $request->user_id)->get();

        return response()->json([
            // 'user_id' => $request->user_id,
            'success' => true,
            'data' => $todo
        ]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $todo = Todo::create([
            'user_id' => $request->user_id,
            'todo' => $request->todo,
            'status' => 'pending',
        ]);

        return response()->json([
            'success' => true,
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

    public function updateStatus(Request $request, Todo $todo) 
    {   
        // dd($request->all());
        
        $todo->status = $request->status;
        $todo->save();

        return response()->json([
            'success' => true,
            'data' => $todo
        ]);
    }

    public function filterStatus(Request $request, Todo $todo) 
    {   
        // dd($request->all());
        if ($request->status && $request->status != 'all') {
            Todo::where('status', $request->status);
        }

        


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Todo $todo)
    {
        // dd($todo);
        $todo->delete();

        return response()->json([
            'success' => true,
            'data' => $todo
        ]);
    }
}
