<?php

namespace App\Models;

use App\Enums\PieceStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Piece extends Model
{
    use HasFactory;
    protected $table = 'pieces';

    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'name',
        'theorical_weight',
        'real_weight',
        'difference',
        'status',
        'block_id',
        'user_id',
        'manufactured_at'
    ];


    // N:1 relationship with Block
    public function block()
    {
        return $this->belongsTo(Block::class, 'block_id', 'id');
    }

    // N:1 relationship with User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function casts(): array
    {
        return [
            'status' => PieceStatusEnum::class,
            'manufactured_at' => 'datetime',
        ];
    }

    // Accessor for difference calculation
    public function getDifferenceAttribute()
    {
        if ($this->real_weight && $this->theorical_weight) {
            return round($this->real_weight - $this->theorical_weight, 2);
        }
        return null;
    }
}
