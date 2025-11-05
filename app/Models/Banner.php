<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;
    public $table = 'Banner';
    protected $fillable = [
        'id',
        'image',
        'IStatus',
        'iSDelete',
        'created_at',
        'updated_at'
    ];
}
