<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BottomVideo extends Model
{
    use HasFactory;

    public $table = 'bottom_video';
    protected $fillable = [
        'id',
        'video',
        'iStatus',
        'isDelete',
        'created_at',
        'updated_at'
    ];
}
