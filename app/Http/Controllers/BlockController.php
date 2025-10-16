<?php

namespace App\Http\Controllers;

use App\Services\BlockService;
use App\Services\ProjectService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BlockController extends Controller
{
    private BlockService $blockService;
    private ProjectService $projectService;

    public function __construct()
    {
        $this->blockService = new BlockService();
        $this->projectService = new ProjectService();
    }

    public function index()
    {
        $blocks = $this->blockService->getAllBlocks();

        // Agrupar bloques por proyecto
        $blocksByProject = $blocks->groupBy('project_id')->map(function ($blocks) {
            return [
                'project' => $blocks->first()->project,
                'blocks' => $blocks
            ];
        })->values();

        return Inertia::render('Admin/Blocks/Index', [
            'blocksByProject' => $blocksByProject
        ]);
    }

    public function create()
    {
        $projects = $this->projectService->getAllProjects();

        return Inertia::render('Admin/Blocks/Create', [
            'projects' => $projects
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|string|max:8|unique:blocks,id',
            'name' => 'required|string|max:4',
            'project_id' => 'required|string|exists:projects,id',
        ]);

        $this->blockService->createBlock($validated);

        return redirect()->route('blocks.index')
            ->with('success', 'Bloque creado exitosamente.');
    }

    public function edit(string $id)
    {
        $block = $this->blockService->getBlockById($id);
        $projects = $this->projectService->getAllProjects();

        return Inertia::render('Admin/Blocks/Edit', [
            'block' => $block,
            'projects' => $projects
        ]);
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:4',
            'project_id' => 'required|string|exists:projects,id',
        ]);

        return $this->blockService->updateBlock($id, $validated);
    }

    public function destroy(string $id)
    {
        if (!$id) {
            return back()->withErrors(['error' => 'Invalid Block ID.']);
        }

        $this->blockService->deleteBlock($id);

        return redirect()->route('blocks.index')
            ->with('success', 'Bloque eliminado exitosamente.');
    }
}
