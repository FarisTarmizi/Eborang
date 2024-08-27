<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Application extends Model
{
    use HasFactory;

    protected $table = 'permohonan';
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
        'verify_at',
        'email_noti',
    ];

    public function application()
    {
        return $this->belongsTo(User_info::class, 'user_id', 'id');
    }

    public function in_charge()
    {
        return $this->belongsTo(User_info::class, 'pic', 'id');
    }
}
