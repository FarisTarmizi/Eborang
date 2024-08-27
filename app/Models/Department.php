<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use mysql_xdevapi\Table;

class Department extends Model
{
    use HasFactory;
    protected $table = 'department';
    protected $fillable = [
        'name',
        'leader',
        'staff_id',
    ];
}
