<?php

namespace App\Services;

use App\Models\Project;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;

class ProjectService
{
    public function getAllProjects(): Collection
    {
        return Project::all();
    }

    public function getProjectById(string $id): ?Project
    {
        if (!$id) {
            return null;
        }
        return Project::find($id);
    }

    public function createProject(array $data): Project
    {
        if (empty($data['project_id'])) {
            throw new \InvalidArgumentException('project_id is required to create a Project.');
        }

        if (empty($data['name'])) {
            throw new \InvalidArgumentException('name is required to create a Project.');
        }

        if (empty($data['id'])) {
            throw new \InvalidArgumentException('id is required to create a Project.');
        }


        return Project::create($data);
    }

    public function updateProject(string $id, array $data): RedirectResponse
    {
        $Project = Project::find($id);
        if (!$Project) {
            return redirect()->back()->with('error', 'Project not found.');
        }

        if (empty($data['name'])) {
            throw new \InvalidArgumentException('name is required to update a Project.');
        }

        $Project->update($data);

        return redirect()->route('projects.index')
            ->with('success', 'Project updated successfully.');
    }

    public function deleteProject(string $id): ?bool
    {
        $Project = Project::find($id, ['id']);
        if (!$Project) {
            return null;
        }
        return $Project->delete();
    }
}
