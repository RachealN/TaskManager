<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Repositories\Tasks;
use App\Models\Task;
use App\Models\Project;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    protected $tasksRepository;

    public function __construct()
    {
        $this->tasksRepository = new Tasks();
    }

    public function index()
    {
        $tasks = $this->tasksRepository->all();

        if ($tasks->hasError()) {
            return response()->json($tasks->getItems(), 500);
        }

        return response()->json($tasks->getItems(), 200);
    }

    public function indexByProject($id)
    {
        $project = Project::findOrFail($id);
        $tasks = $project->tasks()->orderBy('priority')->get();
        return response()->json($tasks);
    }

    public function store(Request $request)
    {

        $tasksStore =
            $this
                ->tasksRepository
                ->store($request->all());

        if ($tasksStore->hasError()) {
            return response()->json($tasksStore->getItems(), 500);
        }

        return response()->json($tasksStore->getItems(), 201);
    }

    public function show($id)
    {
        $taskFetch =
            $this
                ->tasksRepository
                ->show($id);

        if ($taskFetch->hasError()) {
            return response()->json($taskFetch->getItems(), 500);
        }

        return response()->json($taskFetch->getItems(), 200);
    }

    public function update($id, Request $request)
    {

        $taskUpdate =
            $this
                ->tasksRepository
                ->update($id, $request->all());

        if ($taskUpdate->hasError()) {
            return response()->json($taskUpdate->getItems(), 500);
        }

        return response()->json($taskUpdate->getItems(), 200);
    }

    public function delete($id)
    {
        $taskDelete =
            $this
                ->tasksRepository
                ->delete($id);

        if ($taskDelete->hasError()) {
            return response()->json($taskDelete->getItems(), 500);
        }

        return response()->json($taskDelete->getItems(), 200);
    }
}