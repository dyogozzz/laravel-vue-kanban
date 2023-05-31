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
        $task->prioridade = $request->prioridade;
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

    public function editTaskFull(Request $request, $id)
{
    DB::table('tasks')
        ->where('id', $id)
        ->update([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'prioridade' => $request->input('prioridade'),
            'vencimento' => $request->input('vencimento'),
            'usuario' => $request->input('usuario'),
        ]);


        return response()->json(['message' => 'Tarefa atualizada com sucesso']);
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

    public function deleteTask($id) {
        Task::findOrFail($id)->delete();

        return response('msg', 'Deletada com sucesso');
    }
}

