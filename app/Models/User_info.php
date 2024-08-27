<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class User_info extends Model
{
    use HasFactory,Notifiable;
    protected $table = 'user_info';
    protected $fillable=[
        'id',
        'name',
        'email',
        'img',
        'department',
        'phone',
    ];
    public function department1(){
        return $this->belongsTo(Department::class,'department','name');
    }

}
