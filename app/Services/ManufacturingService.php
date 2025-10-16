<?php

namespace App\Services;

use App\Enums\PieceStatusEnum;
use App\Models\Piece;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class ManufacturingService
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
     * Get all projects for manufacturing dashboard
     */
    public function getProjectsForManufacturing(): Collection
    {
        return $this->projectService->getAllProjects();
    }

    /**
     * Get a piece by ID for manufacturing registration
     */
    public function getPieceForManufacturing(int $id): ?Piece
    {
        return $this->pieceService->getPieceById($id);
    }

    /**
     * Validate if a piece can be manufactured
     */
    public function canPieceBeManufactured(Piece $piece): bool
    {
        return $piece->status === PieceStatusEnum::PENDING;
    }

    /**
     * Complete the manufacturing process for a piece
     */
    public function completePieceManufacturing(int $id, array $data): ?Piece
    {
        // Add manufacturing metadata
        $data['status'] = PieceStatusEnum::MANUFACTURED->value;
        $data['user_id'] = Auth::id();
        $data['manufactured_at'] = now();

        return $this->pieceService->updatePiece($id, $data);
    }

    /**
     * Get all data needed for manufacturing registration view
     */
    public function getManufacturingRegistrationData(): array
    {
        return [
            'projects' => $this->projectService->getAllProjects(),
            'blocks' => $this->blockService->getAllBlocks(),
            'auth_user' => Auth::user(),
        ];
    }

    /**
     * Get pending pieces by block for manufacturing selection
     */
    public function getPendingPiecesByBlock(string $blockId): Collection
    {
        return $this->pieceService->getPendingPiecesByBlock($blockId);
    }

    /**
     * Get manufacturing statistics
     */
    public function getManufacturingStatistics(): array
    {
        $allPieces = $this->pieceService->getAllPieces();

        return [
            'total_pieces' => $allPieces->count(),
            'pending_pieces' => $allPieces->where('status', PieceStatusEnum::PENDING)->count(),
            'manufactured_pieces' => $allPieces->where('status', PieceStatusEnum::MANUFACTURED)->count(),
            'completion_percentage' => $allPieces->count() > 0
                ? round(($allPieces->where('status', PieceStatusEnum::MANUFACTURED)->count() / $allPieces->count()) * 100, 2)
                : 0,
        ];
    }
}
