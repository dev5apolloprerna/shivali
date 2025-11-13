<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\SubCategory;


class PDFController extends Controller
{

    public function alllookbook_product($slugname = null)
    {
        $category = \App\Models\Category::where('strSlug', $slugname)->firstOrFail();
        $products = \App\Models\Product::where('category_id', $category->iCategoryId)
            ->where('iStatus', 1)->where('isDelete', 0)->get();
        return view('pdf.AllProduct', compact('products', 'category'));
    }
    public function lookbookPdf($slug)
    {
        $category = \App\Models\Category::where('strSlug', $slug)->firstOrFail();

        $products = \App\Models\Product::where('category_id', $category->iCategoryId)
            ->where('iStatus', 1)->where('isDelete', 0)->get()
            ->map(function ($p) {
                // 1) Normalize relative path
                $raw = ltrim((string)$p->product_image, '/'); // remove leading slash
                if (str_starts_with($raw, 'uploads/')) {
                    $rel = $raw; // DB already has 'uploads/product/...'
                } else {
                    $rel = 'uploads/product/' . $raw; // DB has just filename
                }

                // 2) Absolute local path under /public
                $abs = public_path($rel);
                $fallback = public_path('images/placeholder.jpg');

                // 3) Choose readable source
                $srcPath = is_file($abs) ? $abs : $fallback;

                // 4) Build a data URI (works regardless of chroot/remote)
                //    Also convert WEBP -> JPEG in-memory if needed
                $mime = @mime_content_type($srcPath) ?: 'image/jpeg';
                if (str_ends_with(strtolower($srcPath), '.webp') && function_exists('imagecreatefromwebp')) {
                    $im = @imagecreatefromwebp($srcPath);
                    if ($im) {
                        ob_start();
                        imagejpeg($im, null, 85);
                        imagedestroy($im);
                        $binary = ob_get_clean();
                        $p->pdf_img_src = 'data:image/jpeg;base64,' . base64_encode($binary);
                        return $p;
                    }
                    // webp decode failed → fall through to normal read
                    $srcPath = $fallback;
                    $mime = @mime_content_type($srcPath) ?: 'image/jpeg';
                }

                $binary = @file_get_contents($srcPath);
                if ($binary === false) {
                    $binary = @file_get_contents($fallback);
                    $mime = @mime_content_type($fallback) ?: 'image/jpeg';
                }
                if (strpos($mime, 'image/') !== 0) $mime = 'image/jpeg';

                $p->pdf_img_src = 'data:' . $mime . ';base64,' . base64_encode($binary);
                return $p;
            });
        // dd($products);


        // Load view (no special options needed for data: URIs)
        $pdf = Pdf::loadView('pdf.lookbook', compact('category', 'products'));
        return $pdf->stream('lookbook-' . $category->strCategoryName . '.pdf');
    }
}
