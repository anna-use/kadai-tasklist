<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;    

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Task::all();         
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
         $tasks = Task::findOrFail($id);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         $tasks = new Task;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
         $tasks = Task::findOrFail($id);
    }


}
