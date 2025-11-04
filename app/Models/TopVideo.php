<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopVideo extends Model
{
    use HasFactory;

    public $table = 'top_video';
    protected $fillable = [
        'id',
        'video',
        'iStatus',
        'isDelete',
        'created_at',
        'updated_at'
    ];
}
