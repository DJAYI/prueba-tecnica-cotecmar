<?php

namespace App\Services;

use App\Enums\PieceStatusEnum;
use App\Models\Piece;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class PieceService
{
    public function getAllPieces(): Collection
    {
        return Piece::with(['block.project', 'user'])->get();
    }

    public function getPendingPiecesByBlock(string $blockId): Collection
    {
        return Piece::where('block_id', $blockId)
            ->where('status', PieceStatusEnum::PENDING)
            ->with(['block.project'])
            ->get();
    }

    public function getPieceById(string $id): ?Piece
    {
        if (!$id) {
            return null;
        }
        return Piece::with(['block.project', 'user'])->find($id);
    }

    public function createPiece(array $data): Piece
    {
        $data['status'] = PieceStatusEnum::PENDING;
        $data['id'] = strtoupper(substr(uniqid(), -12)); // Generate 12-char ID

        return Piece::create($data);
    }

    public function updatePiece(string $id, array $data): ?Piece
    {
        $piece = $this->getPieceById($id);

        if (!$piece) {
            return null;
        }

        // If updating to manufactured status, set metadata
        if (isset($data['status']) && $data['status'] === PieceStatusEnum::MANUFACTURED->value) {
            $data['manufactured_at'] = now();
            $data['user_id'] = Auth::id();
        }

        $piece->update($data);

        return $piece->fresh(['block.project', 'user']);
    }

    public function deletePiece(string $id): bool
    {
        $piece = $this->getPieceById($id);

        if (!$piece) {
            return false;
        }

        return $piece->delete();
    }
}
