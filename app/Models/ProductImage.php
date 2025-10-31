<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $table = 'product_images';
    protected $primaryKey = 'pimage_id';
    public $timestamps = false;

    protected $fillable = [
        'image', 'product_id', 'iStatus', 'isDelete', 'created_at', 'updated_at'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }
}
