<?php

namespace App\Http\Controllers;

use App\Enums\PieceStatusEnum;
use App\Models\Piece;
use App\Services\BlockService;
use App\Services\PieceService;
use App\Services\ProjectService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class PieceController extends Controller
{
    protected PieceService $pieceService;
    protected ProjectService $projectService;
    protected BlockService $blockService;

    public function __construct(
        PieceService $pieceService,
        ProjectService $projectService,
        BlockService $blockService
    ) {
        $this->pieceService = $pieceService;
        $this->projectService = $projectService;
        $this->blockService = $blockService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $pieces = $this->pieceService->getAllPieces();
        $projects = $this->projectService->getAllProjects();

        // Group pieces by status
        $piecesByStatus = [
            'pending' => $pieces->where('status', PieceStatusEnum::PENDING)->values(),
            'manufactured' => $pieces->where('status', PieceStatusEnum::MANUFACTURED)->values(),
        ];

        return Inertia::render('Admin/Pieces/Index', [
            'piecesByStatus' => $piecesByStatus,
            'projects' => $projects,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $blocks = $this->blockService->getAllBlocks();

        return Inertia::render('Admin/Pieces/Create', [
            'blocks' => $blocks,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:3',
            'theorical_weight' => 'required|numeric|min:0',
            'block_id' => 'required|string|exists:blocks,id',
        ]);

        $this->pieceService->createPiece($validated);

        return redirect()->route('pieces.index')
            ->with('success', 'Pieza creada exitosamente');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $piece = $this->pieceService->getPieceById($id);

        if (!$piece) {
            return redirect()->route('pieces.index')
                ->with('error', 'Pieza no encontrada');
        }

        $projects = $this->projectService->getAllProjects();
        $blocks = $this->blockService->getAllBlocks();

        return Inertia::render('Admin/Pieces/Edit', [
            'piece' => $piece,
            'projects' => $projects,
            'blocks' => $blocks,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:3',
            'theorical_weight' => 'required|numeric|min:0',
            'block_id' => 'required|string|exists:blocks,id',
        ]);

        $piece = $this->pieceService->updatePiece($id, $validated);

        if (!$piece) {
            return redirect()->route('pieces.index')
                ->with('error', 'Error al actualizar la pieza');
        }

        return redirect()->route('pieces.index')
            ->with('success', 'Pieza actualizada exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $deleted = $this->pieceService->deletePiece($id);

        if (!$deleted) {
            return redirect()->route('pieces.index')
                ->with('error', 'Error al eliminar la pieza');
        }

        return redirect()->route('pieces.index')
            ->with('success', 'Pieza eliminada exitosamente');
    }

    /**
     * Get blocks by project (API endpoint for cascading selects)
     */
    public function getBlocksByProject(string $projectId)
    {
        $blocks = $this->blockService->getBlocksByProject($projectId);

        return response()->json($blocks);
    }

    /**
     * Get pending pieces by block (API endpoint for cascading selects)
     */
    public function getPendingPiecesByBlock(string $blockId)
    {
        $pieces = $this->pieceService->getPendingPiecesByBlock($blockId);

        return response()->json($pieces);
    }

    // ========== MANUFACTURING REGISTRATION ==========

    /**
     * Display manufacturing registration index with filters
     */
    public function manufacturingIndex()
    {
        $projects = $this->projectService->getAllProjects();

        return Inertia::render('Admin/Manufacturing/Index', [
            'projects' => $projects,
        ]);
    }

    /**
     * Show the form for registering manufacturing for a specific pending piece
     */
    public function manufacturingRegister(string $id)
    {
        $piece = $this->pieceService->getPieceById($id);

        if (!$piece) {
            return redirect()->route('manufacturing.index')
                ->with('error', 'Pieza no encontrada');
        }

        if ($piece->status !== PieceStatusEnum::PENDING) {
            return redirect()->route('manufacturing.index')
                ->with('error', 'Solo se pueden registrar piezas pendientes');
        }

        $projects = $this->projectService->getAllProjects();
        $blocks = $this->blockService->getAllBlocks();

        return Inertia::render('Admin/Manufacturing/Register', [
            'piece' => $piece,
            'projects' => $projects,
            'blocks' => $blocks,
            'auth_user' => Auth::user(),
        ]);
    }

    /**
     * Complete the manufacturing registration
     */
    public function manufacturingComplete(Request $request, string $id)
    {
        $validated = $request->validate([
            'real_weight' => 'required|numeric|min:0',
        ]);

        $validated['status'] = PieceStatusEnum::MANUFACTURED->value;

        $piece = $this->pieceService->updatePiece($id, $validated);

        if (!$piece) {
            return redirect()->route('manufacturing.index')
                ->with('error', 'Error al registrar la fabricación');
        }

        return redirect()->route('manufacturing.index')
            ->with('success', 'Fabricación registrada exitosamente');
    }
}
