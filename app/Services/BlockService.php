<?php

namespace App\Services;

use App\Models\Block;
use Illuminate\Database\Eloquent\Collection;

class BlockService
{
    public function getAllBlocks(): Collection
    {
        return Block::all();
    }

    public function getBlockById(int $id): ?Block
    {
        if (!$id) {
            return null;
        }
        return Block::find($id);
    }

    public function createBlock(array $data): Block
    {
        if (empty($data['project_id'])) {
            throw new \InvalidArgumentException('project_id is required to create a Block.');
        }

        if (empty($data['name'])) {
            throw new \InvalidArgumentException('name is required to create a Block.');
        }

        if (empty($data['id'])) {
            throw new \InvalidArgumentException('id is required to create a Block.');
        }


        return Block::create($data);
    }

    public function updateBlock(int $id, array $data): bool
    {
        $block = Block::find($id);
        if (!$block) {
            return false;
        }

        if (empty($data['project_id'])) {
            throw new \InvalidArgumentException('project_id is required to update a Block.');
        }

        if (empty($data['name'])) {
            throw new \InvalidArgumentException('name is required to update a Block.');
        }
        if (empty($data['id'])) {
            throw new \InvalidArgumentException('id is required to update a Block.');
        }

        return $block->update($data);
    }

    public function deleteBlock(int $id): ?bool
    {
        $block = Block::find($id);
        if (!$block) {
            return null;
        }
        return $block->delete();
    }
}
