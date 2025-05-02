<?php

namespace App\Http\Controllers;

use App\Models\Task;

use Illuminate\Http\Request;
use Yajra\DataTables\Contracts\DataTable;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Gate;

use function Pest\Laravel\json;

class TaskController extends Controller
{
    public function index()
    {
        if (Gate::denies('admin-only')) {
            abort(403, 'Akses hanya untuk admin');
        }
        $active = 'task';
        $tasks = Task::all();
        return view(
            'task.index',
            compact('tasks', 'active')
        );
    }

    public function store(Request $request)
    {
        if (Gate::denies('admin-only')) {
            abort(403, 'Akses hanya untuk admin');
        }
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'date' => 'required|date',
            'time' => 'required'
        ]);

        $task = Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'date' => $request->date,
            'time' => $request->time
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Task added successfully!',
            'task' => $task
        ]);
    }

    public function getTasksData(Request $request)
    {
        if (Gate::denies('admin-only')) {
            abort(403, 'Akses hanya untuk admin');
        }
        $tasks = Task::select(['id', 'title', 'description', 'date', 'time']);

        return DataTables::of($tasks)->addIndexColumn()->addColumn('actions', function ($task) {
            return '<button class="btn btn-danger btn-sm" onclick="deleteTask(' . $task->id . ')"><i class="bi bi-trash"></i></button>';
        })->rawColumns(['actions'])->make(true);
    }
}
