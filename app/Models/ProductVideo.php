<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVideo extends Model
{
    protected $table = 'product_videos';
    protected $primaryKey = 'pvideo_id';
    public $timestamps = false;

    protected $fillable = [
        'video_link', 'product_id', 'iStatus', 'isDelete', 'created_at', 'updated_at'
    ];
}
