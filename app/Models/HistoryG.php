<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryG extends Model
{
    use HasFactory;
    protected $table = 'peralatan_history';
    protected $fillable = [
        'user_id',
        'tiket',
        'motive',
        'gear',
        'review',
        'location',
        'start',
        'end',
        'pic',
        'status',
        'gear_id',
        'gear_mssg',
        'created_at',
        'updated_at',
        'verify_at',
        'email_noti',
    ];
}
