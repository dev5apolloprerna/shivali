<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVideo;
use Illuminate\Http\Request;

class ProductVideoController extends Controller
{
    public function index(Product $product)
    {
        $videos = ProductVideo::where('product_id', $product->product_id)
            ->where('isDelete', 0)
            ->orderByDesc('pvideo_id')
            ->get();

        return view('admin.product.videos', compact('product', 'videos'));
    }

    public function store(Request $request, $id)
    {
        $request->validate([
            'video_link' => 'required|string|max:255',
        ]);

        ProductVideo::create([
            'video_link' => $request->video_link,
            'product_id' => $id,
            'iStatus'    => 1,
            'isDelete'   => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Video link added successfully.');
    }

    public function deleteOne($id)
    {
        $video = ProductVideo::find($id);
        if (!$video || $video->isDelete == 1) {
            return back()->with('error', 'Video not found.');
        }

        $video->delete();

        return back()->with('success', 'Video deleted successfully.');
    }
}
