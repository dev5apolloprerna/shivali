<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductTagemaster extends Model
{
    use HasFactory;
    public $table = 'Product_Tagemaster';
    protected $fillable = [
        'product_tag_id',
        'tag_id',
        'product_id',
        'IStatus',
        'ISDelete',
        'created_at',
        'updated_at'
    ];
}
