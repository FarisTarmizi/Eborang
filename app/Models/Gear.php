<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gear extends Model
{
    use HasFactory;
    protected $table = 'gear';
    protected $fillable = [
        'type',
        'model',
        'tag',
        'no_siri',
    ];
    public function category()
    {
        return $this->belongsTo(Gear_Type::class,'type','name');
    }
}
