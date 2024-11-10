<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Task;    

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $data = [];
        if (\Auth::check()) { // 認証済みの場合
            // 認証済みユーザーを取得
            $user = \Auth::user();
            // ユーザーの投稿の一覧を作成日時の降順で取得
            
            $tasks = $user->tasks()->orderBy('created_at', 'desc')->paginate(10);
            $data = [
            'user' => $user,
            'tasks' => $tasks,
            ];
            //dd($tasks);
             return view('tasks.index', $data);
        }
        
        // dashboardビューでそれらを表示
        return view('dashboard', $data);// 追加
    }

    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $task = Task::findOrFail($id);
        if (\Auth::id() === $task->user_id) {
            return view('tasks.show', [
                'task' => $task,
            ]);
        }
        // トップページへリダイレクトさせる
        return redirect('/');
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
        //$task = new Task;
        //$task->content = $request->content;
        //$task->status = $request->status;    // 追加
        //$task->save();
        
         // 認証済みユーザー（閲覧者）の投稿として作成（リクエストされた値をもとに作成）
        $request->user()->tasks()->create([
            'content' => $request->content,
            'status'  => $request->status,
        ]);

        // トップページへリダイレクトさせる
        return redirect('/');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $task = Task::findOrFail($id);
        if (\Auth::id() === $task->user_id) {
            return view('tasks.edit', [
            'task' => $task
            ]);
        }
        // トップページへリダイレクトさせる
        return redirect('/');
    }
    
    public function update(Request $request, string $id)
    {
        
        // バリデーション
        $request->validate([
            'status' => 'required|max:10',   // 追加
            'content' => 'required',
        ]);
            $task = Task::findOrFail($id);
        if (\Auth::id() === $task->user_id) {
            //idの値でメッセージを検索して取得
            
            // メッセージを更新
            $task->status = $request->status;    // 追加
            $task->content = $request->content;
            $task->save();
        }

        // トップページへリダイレクトさせる
        return redirect('/');
    }

    
    public function destroy(string $id)
    {
         // idの値でメッセージを検索して取得
        $task = Task::findOrFail($id);
        // メッセージを削除
        if (\Auth::id() === $task->user_id) {
            $task->delete();
        }

        // トップページへリダイレクトさせる
        return redirect('/');
    }

}
