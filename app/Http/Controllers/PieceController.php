<?php

namespace App\Http\Controllers;

use App\Enums\PieceStatusEnum;
use App\Exports\PiecesReportExport;
use App\Models\Piece;
use App\Services\BlockService;
use App\Services\PieceService;
use App\Services\ProjectService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
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

    public function create()
    {
        $blocks = $this->blockService->getAllBlocks();

        return Inertia::render('Admin/Pieces/Create', [
            'blocks' => $blocks,
        ]);
    }


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


    public function getBlocksByProject(string $projectId)
    {
        $blocks = $this->blockService->getBlocksByProject($projectId);

        return response()->json($blocks);
    }


    public function getPendingPiecesByBlock(string $blockId)
    {
        $pieces = $this->pieceService->getPendingPiecesByBlock($blockId);

        return response()->json($pieces);
    }


    public function manufacturingIndex()
    {
        $projects = $this->projectService->getAllProjects();

        return Inertia::render('Admin/Manufacturing/Index', [
            'projects' => $projects,
        ]);
    }

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

    public function generatePieceReport()
    {
        try {
            Log::info('Iniciando generación de reporte de piezas...');

            $export = new PiecesReportExport($this->pieceService);
            $result = $export->downloadPDF();

            Log::info('Reporte generado exitosamente');

            return response()->json($result);
        } catch (\Exception $e) {
            Log::error('Error al generar el reporte: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return redirect()->back()->with('error', 'Error al generar el reporte: ' . $e->getMessage());
        }
    }
}
