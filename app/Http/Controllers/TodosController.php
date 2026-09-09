<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;
use App\Models\User;

class TodosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Add pagination later
        // $name = Todo::where('name', $request->user_id);
        // $query = Todo::query();
        $query = Todo::with('user:id,name', 'statusRelation:id,name');

        // $sQ = ::where('todo', 'LIKE', '%' . $request->search . '%')->get();
        if ($request->search) {
            $query->where('todo', 'LIKE', '%' . $request->search . '%');
        }    

        if ($request->status_id && $request->status_id !== 'all') {
            $query->where('status_id', $request->status_id);
        }

        // $todo = $query->get();
        $perPage = $request->per_page ? (int) $request->per_page : 10;
        $todo = $query->paginate($perPage);

        return response()->json([
            // 'user_id' => $request->user_id,
            'success' => true,
            'data' => $todo
        ]);

    }

    // public function testSearch(Request $request) 
    // {
    //     // dd($request->all());

    //     $sQ = Todo::where('todo', 'LIKE', '%' . $request->search . '%')->get();
    

    //     return response()->json([
    //         'success' => true,
    //         'data' => $sQ
    //     ]);
    // }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $todo = Todo::create([
            'user_id' => $request->user_id,
            'todo' => $request->todo,
            'status_id' => 1,
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
    public function updateTodoItem(Request $request, Todo $todo)
    {
        //
        $todo->todo = $request->todo;
        $todo->save();

        return response()->json([
            'success' => true,
            'data' => $todo
        ]);
    }

    public function updateStatus(Request $request, Todo $todo) 
    {   
        // dd($request->all());
    
        $todo->status_id = $request->status_id;
        $todo->save();

        return response()->json([
            'success' => true,
            'data' => $todo
        ]);
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
