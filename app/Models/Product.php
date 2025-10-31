<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    protected $table = 'product_master';
    protected $primaryKey = 'product_id';
    public $timestamps = false; // using manual datetime columns

    protected $fillable = [
        'product_name', 'slug', 'product_image', 'description',
        'category_id', 'subcategory_id', 'iStatus', 'isDelete',
        'created_at', 'updated_at',
    ];

    // Relations (adjust to your keys/models)
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'iCategoryId');
    }

    public function subcategory()
    {
        return $this->belongsTo(SubCategory::class, 'subcategory_id', 'iSubCategoryId');
    }

    /** Create unique slug for product_name */
    public static function makeUniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title);
        $slug = $base ?: 'product';
        $i = 1;

        $q = static::query();
        if ($ignoreId) $q->where('product_id', '!=', $ignoreId);

        while ($q->where('slug', $slug)->exists()) {
            $slug = $base.'-'.$i++;
            $q = static::query();
            if ($ignoreId) $q->where('product_id', '!=', $ignoreId);
        }
        return $slug;
    }
}
