<?php

namespace App\Models;

use App\Enums\PieceStatusEnum;
use Illuminate\Database\Eloquent\Model;

class Piece extends Model
{
    protected $table = 'pieces';
    protected $fillable = [
        'name',
        'theorical_weight',
        'real_weight',
        'status',
        'block_id',
        'user_id',
        'manufactured_at'
    ];


    // N:1 relationship with Block
    public function block()
    {
        return $this->belongsTo(Block::class);
    }

    // N:1 relationship with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function casts(): array
    {
        return [
            'status' => PieceStatusEnum::class,
        ];
    }
}
