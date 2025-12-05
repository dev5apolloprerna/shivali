<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CelebrityORDesigner extends Model
{
    use HasFactory;
    public $table = 'CelebrityORDesigner';
    protected $fillable = [
        'id',
        'image',
        'Type',
        'created_at',
        'updated_at'
    ];
}
