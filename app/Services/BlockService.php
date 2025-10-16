<?php

namespace App\Services;

use App\Models\Block;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;

class BlockService
{
    public function getAllBlocks(): Collection
    {
        return Block::with('project')->get();
    }

    public function getBlocksByProject(string $projectId): Collection
    {
        return Block::where('project_id', $projectId)->get();
    }

    public function getBlockById(string $id): ?Block
    {
        if (!$id) {
            return null;
        }
        return Block::with('project')->find($id);
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

    public function updateBlock(string $id, array $data): RedirectResponse
    {
        $block = Block::find($id);
        if (!$block) {
            return redirect()->back()->with('error', 'Block not found.');
        }

        if (empty($data['project_id'])) {
            throw new \InvalidArgumentException('project_id is required to update a Block.');
        }

        if (empty($data['name'])) {
            throw new \InvalidArgumentException('name is required to update a Block.');
        }

        $block->update($data);

        return redirect()->route('blocks.index')
            ->with('success', 'Block updated successfully.');
    }

    public function deleteBlock(string $id): ?bool
    {
        $block = Block::find($id);
        if (!$block) {
            return null;
        }
        return $block->delete();
    }
}
