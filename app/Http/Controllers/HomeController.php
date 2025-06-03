<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function index(Request $request)
    {
        $projects = Project::getAllProjects();
        $tasks = Task::where('user_id', auth()->id())->get();

        $projectFilter = $request->input('projectFilter', 0);
        $statusFilter = $request->input('statusFilter', '');

        if ($projectFilter != 0 || $statusFilter != '') {
            $tasksFilter = [];

            if ($projectFilter != 'all') {
                $tasksFilter['project'] = $projectFilter;
            }

            if ($statusFilter != 'all') {
                $tasksFilter['is_completed'] = ($statusFilter == 'completed') ? 1 : 0;
            }

            $tasks = Task::getAllTasksWithFilters($tasksFilter);
        }

        return view('home.home')->with([
            'projects' => $projects,
            'tasks' => $tasks,
            'projectFilter' => $projectFilter,
            'statusFilter' => $statusFilter,
        ]);
    }
}
