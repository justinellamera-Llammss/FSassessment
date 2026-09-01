<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    //
    protected $table = 'todos_table';

    protected $fillable = ['user_id', 'todo', 'status'];

    
}
