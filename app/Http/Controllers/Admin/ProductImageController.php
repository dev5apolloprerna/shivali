<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;

class ProductImageController extends Controller
{
    public function index(Product $product)
    {
        $images = ProductImage::where('product_id', $product->product_id)
            ->where('isDelete', 0)
            ->orderByDesc('pimage_id')
            ->get();

        return view('admin.product.images', compact('product', 'images'));
    }

  public function store(Request $request, $id)
{
    $request->validate([
        'images'   => 'required',
        'images.*' => 'image|mimes:jpg,jpeg,png,webp|max:4096',
    ]);

    $files = $request->file('images');
    if ($files instanceof \Illuminate\Http\UploadedFile) {
        $files = [$files];
    }

    if (!is_array($files) || empty($files)) {
        return back()->with('error', 'No valid image uploaded.');
    }

    foreach ($files as $file) {
        // upload using helper
        $path = anx_upload($file, 'product');

        // just skip if somehow empty
        if (!$path) continue;

        \App\Models\ProductImage::create([
            'image'      => $path,
            'product_id' => (int)$id,
            'iStatus'    => 1,
            'isDelete'   => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    return back()->with('success', 'Images uploaded successfully.');
}



    /** Delete all product images (with helper) */
    public function destroy($id)
    {
        $photos = ProductImage::where(['isDelete' => 0, 'product_id' => $id])->get();

        if ($photos->isEmpty()) {
            return back()->with('error', 'No images found.');
        }

        foreach ($photos as $photo) {
            if (!empty($photo->image)) {
                anx_delete($photo->image); // ✅ your helper handles file unlink
            }
            $photo->isDelete = 1;
            $photo->updated_at = now();
            $photo->save();
        }

        return back()->with('success', 'All images deleted successfully.');
    }
    public function deleteOne($id)
    {
        $img = \App\Models\ProductImage::find($id);

        if (!$img || $img->isDelete == 1) {
            return back()->with('error', 'Image not found.');
        }

        // Delete physical file using helper
        if (!empty($img->image)) {
            anx_delete($img->image);
        }

        // Soft delete in DB
        $img->delete();

        return back()->with('success', 'Image deleted successfully.');
    }

}
