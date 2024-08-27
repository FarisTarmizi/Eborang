<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class HistoryA extends Model
{
    use HasFactory;

    protected $table = 'capaian_history';
    protected $fillable = [
        'user_id',
        'tiket',
        'category',
        'acct_name',
        'reason',
        'review',
        'pic',
        'status',
        'verify_at',
        'email_noti',
    ];
}
