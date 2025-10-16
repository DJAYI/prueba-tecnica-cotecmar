<?php

namespace App\Http\Controllers;

use App\Services\ManufacturingService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ManufacturingController extends Controller
{
    protected ManufacturingService $manufacturingService;

    public function __construct(ManufacturingService $manufacturingService)
    {
        $this->manufacturingService = $manufacturingService;
    }

    /**
     * Display the manufacturing dashboard
     */
    public function index()
    {
        $projects = $this->manufacturingService->getProjectsForManufacturing();
        $statistics = $this->manufacturingService->getManufacturingStatistics();

        return Inertia::render('Admin/Manufacturing/Index', [
            'projects' => $projects,
            'statistics' => $statistics,
        ]);
    }

    /**
     * Show the form for registering a piece manufacturing
     */
    public function register(int $id)
    {
        $piece = $this->manufacturingService->getPieceForManufacturing($id);

        if (!$piece) {
            return redirect()->route('manufacturing.index')
                ->with('error', 'Pieza no encontrada');
        }

        if (!$this->manufacturingService->canPieceBeManufactured($piece)) {
            return redirect()->route('manufacturing.index')
                ->with('error', 'Solo se pueden registrar piezas pendientes');
        }

        $additionalData = $this->manufacturingService->getManufacturingRegistrationData();

        return Inertia::render('Admin/Manufacturing/Register', array_merge([
            'piece' => $piece,
        ], $additionalData));
    }

    /**
     * Complete the manufacturing process for a piece
     */
    public function complete(Request $request, int $id)
    {
        $validated = $request->validate([
            'real_weight' => 'required|numeric|min:0',
        ]);

        $piece = $this->manufacturingService->completePieceManufacturing($id, $validated);

        if (!$piece) {
            return redirect()->route('manufacturing.index')
                ->with('error', 'Error al registrar la fabricación');
        }

        return redirect()->route('manufacturing.index')
            ->with('success', 'Fabricación registrada exitosamente');
    }

    /**
     * Get pending pieces by block (API endpoint)
     */
    public function getPendingPiecesByBlock(string $blockId)
    {
        $pieces = $this->manufacturingService->getPendingPiecesByBlock($blockId);

        return response()->json($pieces);
    }
}
