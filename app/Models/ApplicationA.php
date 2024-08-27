<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class ApplicationA extends Model
{
    use HasFactory;

    protected $table = 'permohonan_capaian';
    protected $fillable = [
        'user_id',
        'tiket',
        'category',
        'detail',
        'acct_name',
        'reason',
        'review',
        'pic',
        'status',
        'verify_at',
        'email_noti',
    ];

    public function application2()
    {
        return $this->belongsTo(User_info::class, 'user_id', 'id');
    }

    public function in_charge2()
    {
        return $this->belongsTo(User_info::class, 'pic', 'id');
    }
}
