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
        
          return view('tasks.index', [     // 追加
            'tasks' => $tasks,             // 追加
        ]);                                // 追加
    }

    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
         $task = Task::findOrFail($id);
            return view('tasks.show', [
            'task' => $task,
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         $task = new Task;
          // メッセージ作成ビューを表示
        return view('tasks.create', [
            'task' => $task,
        ]);
    }

  public function store(Request $request)
    {
         $request->validate([
            'status' => 'required|max:10',   // 追加
            'content' => 'required',
        ]);
        $task = new Task;
        $task->content = $request->content;
        $task->status = $request->status;    // 追加
        $task->save();

        // トップページへリダイレクトさせる
        return redirect('/');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
         $task = Task::findOrFail($id);
         return view('tasks.edit', [
            'task' => $task,
        ]);
    }
    
    public function update(Request $request, string $id)
    {
        // バリデーション
        $request->validate([
            'status' => 'required|max:10',   // 追加
            'content' => 'required',
        ]);
        
        //idの値でメッセージを検索して取得
        $task = Task::findOrFail($id);
        // メッセージを更新
        $task->status = $request->status;    // 追加
        $task->content = $request->content;
        $task->save();

        // トップページへリダイレクトさせる
        return redirect('/');
    }

    
    public function destroy(string $id)
    {
         // idの値でメッセージを検索して取得
        $task = Task::findOrFail($id);
        // メッセージを削除
        $task->delete();

        // トップページへリダイレクトさせる
        return redirect('/');
    }

}
