<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TagMaster extends Model
{
    use HasFactory;
    public $table = 'TagMaster';
    protected $fillable = [
        'id',
        'Name',
        'IStatus',
        'ISDelete',
        'created_at',
        'updated_at'
    ];
}
