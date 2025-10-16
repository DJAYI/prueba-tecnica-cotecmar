<?php

namespace App\Services;

use App\Models\Piece;
use Illuminate\Database\Eloquent\Collection;

class PieceService
{
    public function getAllPieces(): Collection
    {
        return Piece::all();
    }

    public function getPieceById(int $id): ?Piece
    {
        if (!$id) {
            return null;
        }
        return Piece::find($id);
    }

    public function createPiece(array $data): Piece
    {
        return Piece::create($data);
    }
}
