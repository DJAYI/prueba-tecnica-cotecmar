<?php

namespace App\Services;

use App\Models\Project;
use Illuminate\Database\Eloquent\Collection;

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

    public function updateProject(string $id, array $data): bool
    {
        $Project = Project::find($id);
        if (!$Project) {
            return false;
        }

        if (empty($data['name'])) {
            throw new \InvalidArgumentException('name is required to update a Project.');
        }
        if (empty($data['id'])) {
            throw new \InvalidArgumentException('id is required to update a Project.');
        }

        return $Project->update($data);
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
