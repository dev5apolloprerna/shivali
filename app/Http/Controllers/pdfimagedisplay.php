<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\SubCategory;
use App\Models\Product;

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
        $category = Category::where('strSlug', $slug)->firstOrFail();

        // Real webroot: /home1/getdemo/public_html[/Shivali]
        $docroot = rtrim($_SERVER['DOCUMENT_ROOT'] ?? '', '/');               // /home1/getdemo/public_html
        $subdir  = 'Shivali'; // "Shivali" or ""
        // dd($subdir);
        $webroot = $subdir ? "$docroot/$subdir" : $docroot;                   // e.g. /home1/getdemo/public_html/Shivali
        // dd($webroot);
        $products = Product::orderBy('product_id', 'desc')->where('category_id', $category->iCategoryId)
            ->where('iStatus', 1)->where('isDelete', 0)
            ->get()
            ->map(function ($p) use ($webroot) {
                $rel = ltrim((string)$p->product_image, '/');          // uploads/product/xxx.jpeg
                $abs = $webroot . '/' . $rel;
                $fallback = $webroot . '/images/no-image.jpg';
                $p->pdf_img_src = is_file($abs) ? $abs : $fallback;    // local path (option A)
                $p->img_url = asset($rel);                             // https://getdemo.in/Shivali/uploads/...
                return $p;
            });

        // Ensure Dompdf can read files under $webroot
        $pdf = Pdf::setOptions([
            'isRemoteEnabled' => true,
            'isHtml5ParserEnabled' => true,
            'isPhpEnabled' => true,
            'dpi' => 96,
            'chroot' => $webroot,
        ])
            ->setPaper('a4', 'portrait')
            ->loadView('pdf.lookbook', compact('category', 'products'));

        return $pdf->stream('lookbook-' . $category->strCategoryName . '.pdf');
    }

    private function resolveImagePathForPdf(?string $relative): string
    {
        $fallback = public_path('images/no-image.jpg');
        if (!$relative) return $fallback;

        $rel = ltrim($relative, '/');
        $docroot = rtrim($_SERVER['DOCUMENT_ROOT'] ?? '', '/');
        $subdir  = trim(parse_url(config('app.url'), PHP_URL_PATH) ?? '', '/');
        $webroot = $subdir ? "$docroot/$subdir" : $docroot;

        $candidateA = $webroot . '/' . $rel;   // ✅ no extra /Shivali
        return is_file($candidateA) ? $candidateA : $fallback;  // ✅ always return something
    }
}
