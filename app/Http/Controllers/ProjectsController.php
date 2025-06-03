<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;

class ProjectsController extends Controller
{

    public function insert(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'color' => 'required|string|max:50',
        ]);

        // Create a new project
        $time = time();
        $project = Project::createProject([
            'name' => $request->name,
            'color' => $request->color,
            'created_at' => $time,
            'updated_at' => $time
        ]);

        return redirect()->route('home.index');
    }


    public function update(Request $request, $id)
    {
        $project = Project::find($id);

        if (!$project) {
            abort(404, 'Project not found.');
        }

        $validatedData = $request->validate([
            'name' => 'required|string',
            'color' => 'required|string|max:50',
        ]);

        $project->updateProject([
            'name' => $request->name,
            'color' => $request->color,
            'updated_at' => time()
        ]);

        return redirect()->route('home.index');
    }


    public function delete($id)
    {
        $project = Project::find($id);

        if (!$project) {
            abort(404, 'Project not found.');
        }

        $project->delete();

        return redirect()->route('home.index');
    }
}
