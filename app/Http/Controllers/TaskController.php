<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    public function create(Request $request) {
        $task = new Task;

        $task->title = $request->title;
        $task->description = $request->description;
        $task->status = $request->status;
        $task->vencimento = $request->vencimento;
        $task->usuario = $request->usuario;

        $task->save();

        return response()->json(['message' => 'deu certo']);
    }

    public function edit(Request $request, $id) {
        DB::table('tasks')
        ->where('id', $id)
        ->update([
            'status' => $request->status
        ]);

        return response()->json(['message' => 'Deu certo']);
    }

    public function login() {
        return view('obrigatoriedade');
    }

    public function AllTasks() {
        $tasks = Task::all();
    
        return response()-> json($tasks);
    }

    public function tasks($id) {
        $task = Task::findOrFail($id);

        return view('task', ['task' => $task]);
    }
}