<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Block extends Model
{
    use HasFactory;

    protected $table = 'blocks';
    protected $fillable = [
        'id',
        'name',
        'project_id',
    ];

    // N:1 relationship with Project
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
