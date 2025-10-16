<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Services\ProjectService;

class ProjectController extends Controller
{
    private ProjectService $projectService;

    public function __construct()
    {
        $this->projectService = new ProjectService();
    }


    public function index()
    {
        $projects = $this->projectService->getAllProjects();

        return Inertia::render('Admin/Projects/Index', [
            'projects' => $projects
        ]);
    }


    public function create()
    {
        return Inertia::render('Admin/Projects/Create');
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|integer|unique:projects,id',
            'name' => 'required|string|max:255',
        ]);

        $this->projectService->createProject($validated);
    }

    public function edit(string $id)
    {
        $project = $this->projectService->getProjectById($id);

        return Inertia::render('Admin/Projects/Edit', [
            'project' => $project
        ]);
    }


    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        return $this->projectService->updateProject($id, $validated);
    }

    public function destroy(string $id)
    {
        if (!$id) {
            return back()->withErrors(['error' => 'Invalid Project ID.']);
        }

        $this->projectService->deleteProject($id);
    }
}
